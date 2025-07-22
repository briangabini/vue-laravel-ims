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
        $logType = $request->query('logType', 'security');
        $logFile = match ($logType) {
            'warning' => 'warning.log',
            'error' => 'error.log',
            'debug' => 'debug.log',
            'info' => 'info.log',
            default => 'security.log',
        };

        $logFilePath = storage_path('logs/' . $logFile);
        $allLogs = [];

        if (file_exists($logFilePath)) {
            $fileContent = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $currentLogEntry = null;

            foreach ($fileContent as $line) {
                // Check if the line starts with a timestamp pattern
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] ([a-zA-Z0-9_\.]+): (.*)$/', $line, $matches)) {
                    // If there's a previous log entry, add it to allLogs
                    if ($currentLogEntry !== null) {
                        $allLogs[] = $currentLogEntry;
                    }
                    // Start a new log entry
                    $currentLogEntry = [
                        'timestamp' => $matches[1],
                        'level' => $matches[2],
                        'message' => trim($matches[3]),
                        'summary' => trim($matches[3]), // Initialize summary with the first line
                    ];
                } else if ($currentLogEntry !== null) {
                    // This line is a continuation of the previous log entry
                    $currentLogEntry['message'] .= "\n" . trim($line);
                } else {
                    // If a line doesn't start with a timestamp and there's no current entry,
                    // it might be a malformed line at the beginning of the file.
                    // For now, we'll just add it as an unknown entry.
                    $allLogs[] = [
                        'timestamp' => 'N/A',
                        'level' => 'UNKNOWN',
                        'message' => trim($line),
                        'summary' => trim($line),
                    ];
                }
            }

            // Add the last log entry if it exists
            if ($currentLogEntry !== null) {
                $allLogs[] = $currentLogEntry;
            }
        }

        // Manual Pagination
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage('page');
        $currentItems = array_slice($allLogs, ($currentPage - 1) * $perPage, $perPage);

        $logs = new LengthAwarePaginator($currentItems, count($allLogs), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'query' => ['logType' => $logType],
        ]);

        return Inertia::render('admin/Logs', [
            'logs' => $logs,
            'logType' => $logType,
        ]);
    }
}
