<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class AdminLogController extends Controller
{
    public function index(Request $request)
    {
        $logFilePath = storage_path('logs/security.log');
        $allLogs = [];

        if (file_exists($logFilePath)) {
            $fileContent = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($fileContent as $line) {
                // Basic parsing: assuming log format like [YYYY-MM-DD HH:MM:SS] LEVEL: MESSAGE
                if (preg_match('/^\[(.*)\] ([\w.]+): (.*)$/', $line, $matches)) {
                    $allLogs[] = [
                        'timestamp' => $matches[1],
                        'level' => $matches[2],
                        'message' => $matches[3],
                    ];
                } else {
                    // Fallback for unparsable lines
                    $allLogs[] = [
                        'timestamp' => 'N/A',
                        'level' => 'UNKNOWN',
                        'message' => $line,
                    ];
                }
            }
        }

        // Manual Pagination
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage('page');
        $currentItems = array_slice($allLogs, ($currentPage - 1) * $perPage, $perPage);

        $logs = new LengthAwarePaginator($currentItems, count($allLogs), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
        ]);

        return Inertia::render('admin/Logs', [
            'logs' => $logs,
        ]);
    }
}
