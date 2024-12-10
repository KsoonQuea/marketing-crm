<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCaseLogRequest;
use App\Http\Requests\UpdateUserCaseLogRequest;
use App\Http\Resources\Admin\UserCaseLogResource;
use App\Models\UserCaseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserCaseLogApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_case_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserCaseLogResource(UserCaseLog::with(['user', 'case'])->get());
    }

    public function store(StoreUserCaseLogRequest $request)
    {
        $userCaseLog = UserCaseLog::create($request->all());

        return (new UserCaseLogResource($userCaseLog))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserCaseLog $userCaseLog)
    {
        abort_if(Gate::denies('user_case_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserCaseLogResource($userCaseLog->load(['user', 'case']));
    }

    public function update(UpdateUserCaseLogRequest $request, UserCaseLog $userCaseLog)
    {
        $userCaseLog->update($request->all());

        return (new UserCaseLogResource($userCaseLog))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserCaseLog $userCaseLog)
    {
        abort_if(Gate::denies('user_case_log_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userCaseLog->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
