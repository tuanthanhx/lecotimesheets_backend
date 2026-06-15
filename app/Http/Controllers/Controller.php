<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function deleteOrConflict(Model $model, string $successMessage, string $conflictMessage): JsonResponse
    {
        try {
            $model->delete();
        } catch (QueryException $exception) {
            if ($this->isForeignKeyConstraintViolation($exception)) {
                return response()->json(['message' => $conflictMessage], 409);
            }

            throw $exception;
        }

        return response()->json(['message' => $successMessage], 200);
    }

    private function isForeignKeyConstraintViolation(QueryException $exception): bool
    {
        $sqlState = (string) ($exception->errorInfo[0] ?? $exception->getCode());
        $driverCode = $exception->errorInfo[1] ?? null;

        return $sqlState === '23000'
            || $sqlState === '23503'
            || in_array((int) $driverCode, [19, 1451], true);
    }
}
