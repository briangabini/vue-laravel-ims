<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AdminLogController extends Controller
{
    public function index()
    {
        $logFilePath = storage_path('logs/security.log');
        $logs = [];

        if (file_exists($logFilePath)) {
            $fileContent = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($fileContent as $line) {
                // Basic parsing: assuming log format like [YYYY-MM-DD HH:MM:SS] LEVEL: MESSAGE
                if (preg_match('/^\[(.*)\] ([\w.]+): (.*)$/', $line, $matches)) {
                    $logs[] = [
                        'timestamp' => $matches[1],
                        'level' => $matches[2],
                        'message' => $matches[3],
                    ];
                } else {
                    // Fallback for unparsable lines
                    $logs[] = [
                        'timestamp' => 'N/A',
                        'level' => 'UNKNOWN',
                        'message' => $line,
                    ];
                }
            }
        }

        return Inertia::render('admin/Logs', [
            'logs' => $logs,
        ]);
    }
}
