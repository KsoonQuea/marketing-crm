<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\CaseList;
use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use File;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use stdClass;
use Session;
use App\Http\Requests\Traits\StoreMediaMediaUploadingTraitRequest;

class DocumentController extends Controller
{
    protected $base_path;

    use CsvImportTrait;
    use MediaUploadingTrait;

    public function getDocumentsDirectory(CaseList $caseList)
    {
        $this->base_path = storage_path('app/public/cases/' . $caseList->id);

        switch ($caseList->case_status){
            case 0 : case 1 : case 2 :
            $caseType_class = 'management_class';
            $caseType_num   = 0;
            break;

            case 3 :
                $caseType_class = 'bfe_class';
                $caseType_num   = 1;
                break;

            case 4 : case 5 :
            $caseType_class = 'drop_class';
            $caseType_num   = 2;
            break;

            default:
                $caseType_class = '';
                $caseType_num   = 3;
                break;
        }

        if (!File::isDirectory($this->base_path)) {
            $this->initFolders($caseList, $this->base_path);
        }

        $directories_file = new stdClass();
        $flag = true;
        $this->getAllFoldersAndFiles($caseList, $this->base_path, $this->base_path, $directories_file, 1);

        $default_directory = $directories_file->children;

        $documentPermission = checkCaseDocumentPermissions($caseList);
        return view('admin.caseLists.showComponents.document-show', compact('default_directory','documentPermission', 'caseType_class', 'caseType_num'))->render();
    }

    public function getAllFoldersAndFiles($caseList, $path, $base_path, $directories_file, $lvl)
    {
        $path_key = str_replace($base_path, "", $path);
        $path_key = str_replace('/', "", $path_key);
        if ($path_key == '') $path_key = 'default';
        $this->getFileInSingleDirectory($caseList->getMedia('document'), $path, $directories_file, $base_path, $lvl);
        $temp = $directories_file->children->$path_key;
        $lvl++;
        $directories = File::directories($path);

        if ($directories) {
            foreach ($directories as $directory) {
                $this->getAllFoldersAndFiles($caseList, $directory, $path, $temp, $lvl);
            }
        }
    }

    public function getFileInSingleDirectory($medias, $path, $directories_file, $base_path, $lvl)
    {

        $path_key = str_replace($base_path, "", $path);
        $path_key = str_replace('/', "", $path_key);
        if ($path_key == '') $path_key = 'default';
        $save_path_key = str_replace($this->base_path . "/", "", $path);
        $save_path_key = str_replace($this->base_path, "", $save_path_key);
        if (!isset($directories_file->children)) {
            $directories_file->children = new stdClass();
        }
        if (!isset($directories_file->children->$path_key)) {
            $directories_file->children->$path_key = new stdClass();
            $directories_file->children->$path_key->lvl = $lvl;
            $directories_file->children->$path_key->path = $save_path_key;
            $directories_file->children->$path_key->media = [];
        }
        foreach ($medias as $media) {
            if (($path_key == 'default' && !isset($media->custom_properties['path'])) || $media->custom_properties['path'] == $save_path_key) {
                $directories_file->children->$path_key->media[] = $media;
            }
        }
    }

    public function restore(CaseList $caseList)
    {
        abort_if(Gate::denies('case_list_remove'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $caseList->update([
            'case_status' => 0,
        ]);

        return redirect()->back();
    }

    public function zip(Request $request, CaseList $caseList)
    {
        try {
            $mediaid = explode(",", $request->input('mediaid'));
            $media_paths = Media::whereIn('id', $mediaid)->get()->pluck('file_name', 'id');
            $zip = new \ZipArchive();
            $new_zip_name = ($caseList->company_name??$caseList->id).'.zip'; // naming new zip name
            $zip_path = storage_path('tmp/' . $new_zip_name);
            if ($zip->open($zip_path, \ZipArchive::CREATE) !== TRUE) {
                return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->withErrors(['Could not open ZIP file.']);
            }

            foreach ($media_paths as $id => $media_path) {
                $file_path = public_path('storage/' . $id . "/" . $media_path);
                if (!$zip->addFile($file_path, basename($file_path))) {
                    return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->withErrors(['Could not add file to ZIP: ' . $file_path]);
                }
            }

            $zip->close();

            return response()->download($zip_path)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->withErrors([$message]);
        }
    }

    public function directorCommitment(Request $request)
    {
        $director = $request->director;

        $num = strpos($director, " (");

        if ($num == '') {
            return json_encode([
                "director_name" => $director,
                "director_ic" => null,
                "director_email" => null,
                "director_phone" => null,
                "director_gender" => null,
                "director_marital" => null,
            ]);
        } else {
            $director_name = substr($director, 0, $num);

            $removeBehindBreaker = substr($director, $num, -1);
            $director_ic = substr($removeBehindBreaker, 2);

            $director_count = Director::where('name', '=', $director_name)->where('ic', '=', $director_ic)->count();

            if ($director_count != 0) {
                $director_details = Director::where('name', '=', $director_name)->where('ic', '=', $director_ic)->first();

                return json_encode([
                    "director_id" => $director_details->id,
                    "director_name" => $director_name,
                    "director_ic" => $director_ic,
                    "director_email" => $director_details->email,
                    "director_phone" => $director_details->phone,
                    "director_gender" => $director_details->gender,
                    "director_marital" => $director_details->marital_status,
                ]);
            } else {

                return json_encode([
                    "director_name" => $director_name,
                    "director_ic" => null,
                    "director_email" => null,
                    "director_phone" => null,
                    "director_gender" => null,
                    "director_marital" => null,
                ]);
            }
        }
    }

    public function removeFolder(Request $request, CaseList $caseList, $type)
    {
        try {
            $folder_name = $request->input('path', "");
            $path = storage_path('app/public/cases/' . $caseList->id).'/'.$folder_name ;
            File::deleteDirectory($path);
            foreach($caseList->media as $media){
                if($media->getCustomProperty('path')==$folder_name){
                    $media->delete();
                }
            }

            if ($type == 'create') {
                return $request->input('document');
            } else {
                return redirect()->route('admin.case-lists.show-attachment', [$caseList->id, '#documents'])->with('message', 'Document deleted successfully');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if ($type == 'create') {
                return 'fail';
            } else {
                return redirect()->route('admin.case-lists.show-attachment', [$caseList->id, '#documents'])->withErrors([$message]);
            }
        }
    }

    public function initFolders(CaseList $caseList, $base_path)
    {
        $folders_name = ['Audited Reports', 'Bank Statements', 'CCRIS', 'Aging Reports', 'Letter Of Awards', 'Other Documents'];
        if (!File::isDirectory($base_path)) {
            File::makeDirectory($base_path, 0755, true, true);
        }
        foreach ($folders_name as $folder_name) {
            $path = $base_path . '/' . $folder_name;
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }
        }
    }

    public function storeDocuments(Request $request, CaseList $caseList, $type)
    {
        try {
            $path = $request->input('path', "");
            if (isset($path)) $path = "";
            if ($request->input('document', false)) {
                foreach ($request->input('document', []) as $uploadedImage) {
                    $caseList->addMedia(storage_path('tmp/uploads/' . $uploadedImage))
                        ->sanitizingFileName(function($uploadedImage) {
                            return $uploadedImage;
                            //return str_replace(['#', '/', '\\', ' ','-'], ' ', $uploadedImage);
                        })
                        ->withCustomProperties(['path' => $request->input('path', "")])
                        ->toMediaCollection('document');
                }
            }

            if ($type == 'create'){
                return $request->input('document');
            }
            else{
                return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->with('message', 'Document uploaded successfully');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if ($type == 'create'){
                return 'fail';
            }
            else {
                return redirect()->route('admin.case-lists.show-attachment', [$caseList->id, '#documents'])->withErrors([$message]);
            }
        }
    }

    public function newFolders(Request $request, CaseList $caseList, $type)
    {
        try {
            $path = storage_path('app/public/cases/' . $caseList->id);
            if ($request->input('path', "") != "") {
                $path .= "/" . $request->input('path', "");
            }
            $path .= "/" . $request->input('folder_name', "");
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            if ($type == 'create'){
                return 'success';
            }
            else{
                return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->with('message', 'Folder created successfully');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            if ($type == 'create'){
                return 'fail';
            }
            else {
                return redirect()->route('admin.case-lists.show-attachment', [$caseList->id, '#documents'])->withErrors([$message]);
            }
        }
    }

    public function delete(Request $request, CaseList $caseList)
    {
        try {
            $mediaid    = explode(",", $request->input('mediaid'));
            $type       = explode(",", $request->input('type'));
            foreach ($caseList->media as $media) {
                if (in_array($media->id, $mediaid)) {
                    $media->delete();
                }
            }

            if ($type == 'create'){
                return 'success';
            }
            else{
                return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->with('message', 'Document deleted successfully');
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();

            if ($type == 'create'){
                return 'fail';
            }
            else{
                return redirect()->route('admin.case-lists.show-attachment',[$caseList->id,'#documents'])->withErrors([$message]);
            }
        }
    }

    public function remove(CaseList $caseList)
    {
        abort_if(Gate::denies('case_list_remove'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $caseList->update([
            'case_status' => 4,
        ]);

        return redirect()->back();
    }
}
