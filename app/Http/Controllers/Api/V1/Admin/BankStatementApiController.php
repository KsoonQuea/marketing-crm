<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankStatementRequest;
use App\Http\Requests\UpdateBankStatementRequest;
use App\Http\Resources\Admin\BankStatementResource;
use App\Models\BankStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BankStatementApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('bank_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BankStatementResource(BankStatement::with(['bank', 'case'])->get());
    }

    public function store(StoreBankStatementRequest $request)
    {
        $bankStatement = BankStatement::create($request->all());

        return (new BankStatementResource($bankStatement))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BankStatement $bankStatement)
    {
        abort_if(Gate::denies('bank_statement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BankStatementResource($bankStatement->load(['bank', 'case']));
    }

    public function update(UpdateBankStatementRequest $request, BankStatement $bankStatement)
    {
        $bankStatement->update($request->all());

        return (new BankStatementResource($bankStatement))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BankStatement $bankStatement)
    {
        abort_if(Gate::denies('bank_statement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankStatement->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
