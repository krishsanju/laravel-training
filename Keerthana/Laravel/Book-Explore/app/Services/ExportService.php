<?php

namespace App\Services;

use App\Models\User;

class ExportService
{
    public function exportUsersFavoritesCsv()
    {
        $fileName = 'users_favorites_report.csv';

        $users = User::withCount('favorites')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['User ID', 'Name', 'Email', 'Favorite Count']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->favorites_count
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}