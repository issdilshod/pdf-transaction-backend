<?php

namespace App\Services\Statements;

use App\Http\Resources\Statements\StatementResource;
use App\Models\Statements\Statement;
use Illuminate\Support\Facades\Config;

class StatementService {

    public function get_statements()
    {
        $statements = Statement::orderBy('created_at', 'DESC')
                                    ->where('status', Config::get('custom.status.active'))
                                    ->paginate(20);
        return StatementResource::collection($statements);
    }

    public function get_statement(Statement $statement)
    {
        $statement = new StatementResource($statement);
        return $statement;
    }

    public function create_statement($statement)
    {
        $created = Statement::create($statement);
        return new StatementResource($created);
    }

    public function update_statement($update, Statement $statement)
    {
        $statement->update($update);
        return new StatementResource($statement);
    }

    public function delete_statement(Statement $statement)
    {
        $statement->update(['status' => Config::get('custom.status.delete')]);
    }

    public function trash_statement($id)
    {

    }
}