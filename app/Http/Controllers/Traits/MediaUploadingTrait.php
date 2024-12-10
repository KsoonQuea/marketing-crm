<?php

namespace App\Http\Controllers\Traits;

use App\Http\Requests\Traits\StoreMediaMediaUploadingTraitRequest;
use Illuminate\Http\Request;

trait MediaUploadingTrait
{
    public function storeMedia(StoreMediaMediaUploadingTraitRequest $request, $pre_file_name = null)
    {
        // Validates file size
        if ($request->has('size')) {
        }
        // If width or height is preset - we are validating it as an image
        // if ($request->has('width') || $request->has('height')) {
        //     $this->validate(request(), [
        //         'file' => sprintf(
        //             'image|dimensions:max_width=%s,max_height=%s',
        //             $request->input('width', 100000),
        //             $request->input('height', 100000)
        //         ),
        //     ]);
        // }

        $path = storage_path('tmp/uploads');

        try {
            if (! file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        $file = $request->file('file');

        $name = trim($file->getClientOriginalName());// remain original file name
//        if(isset($pre_file_name)){
//            $name = $pre_file_name.'_'.trim($file->getClientOriginalName());
//        }else{
//            $name = uniqid().'_'.trim($file->getClientOriginalName());
//        }

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
