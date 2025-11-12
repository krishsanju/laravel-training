<?php

namespace App\Services;

use App\Models\ActionLog;

class ActionLogService
{
    public function log(int $userId, string $action, ?string $details = null): ActionLog
    {
        return ActionLog::create([
            'user_id' => $userId,
            'action'  => $action,
            'details' => $details,
        ]);
    }

    public function getLogsForUser(int $userId)
    {
        return ActionLog::where('user_id', $userId)
            ->latest()
            ->get(['id', 'action', 'details', 'created_at']);
    }

    public function getAllLogs()
    {
        return ActionLog::all();
    }
}
