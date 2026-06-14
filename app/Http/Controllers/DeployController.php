<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeployController extends Controller
{
    public function database(Request $request): JsonResponse
    {
        $secret = config('app.deploy_secret');
        $token = (string) $request->query('token', '');

        if (! is_string($secret) || $secret === '' || ! hash_equals($secret, $token)) {
            abort(404);
        }

        $seed = (string) $request->query('seed', 'production');

        if (! in_array($seed, ['production', 'demo'], true)) {
            return response()->json([
                'message' => 'Invalid seed mode. Use production or demo.',
            ], 422);
        }

        $steps = [];

        try {
            Artisan::call('migrate', ['--force' => true]);
            $steps[] = [
                'command' => 'migrate --force',
                'output' => trim(Artisan::output()),
            ];

            if ($seed === 'demo') {
                $tableCounts = [
                    'users' => DB::table('users')->count(),
                    'jobs' => DB::table('jobs')->count(),
                    'timesheets' => DB::table('timesheets')->count(),
                ];

                if (array_sum($tableCounts) > 0) {
                    return response()->json([
                        'message' => 'Demo seed was not run because one or more core tables already contain data.',
                        'table_counts' => $tableCounts,
                        'migrate_output' => $steps,
                    ], 409);
                }

                Artisan::call('db:seed', [
                    '--class' => 'Database\\Seeders\\DatabaseSeeder',
                    '--force' => true,
                ]);
            } else {
                Artisan::call('db:seed', [
                    '--class' => 'Database\\Seeders\\ProductionAdminSeeder',
                    '--force' => true,
                ]);
            }

            $steps[] = [
                'command' => "db:seed --class={$seed}",
                'output' => trim(Artisan::output()),
            ];

            return response()->json([
                'message' => 'Database deployment completed.',
                'seed' => $seed,
                'steps' => $steps,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Database deployment failed.',
                'error' => $exception->getMessage(),
                'steps' => $steps,
            ], 500);
        }
    }
}
