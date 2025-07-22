<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminLogController extends Controller
{
    public function index()
    {
        // In a real application, you would fetch logs from a log file or database.
        // For now, we'll return dummy data.
        $logs = [
            ['id' => 1, 'timestamp' => '2025-07-21 10:00:00', 'level' => 'INFO', 'message' => 'User admin@example.com logged in.'],
            ['id' => 2, 'timestamp' => '2025-07-21 10:05:00', 'level' => 'WARN', 'message' => 'Failed login attempt for user manager@example.com.'],
            ['id' => 3, 'timestamp' => '2025-07-21 10:10:00', 'level' => 'ERROR', 'message' => 'Product update failed for ID 123.'],
        ];

        return Inertia::render('admin/Logs', [
            'logs' => $logs,
        ]);
    }
}
