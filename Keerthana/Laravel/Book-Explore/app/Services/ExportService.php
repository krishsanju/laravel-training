<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ExportFailedException;

class ExportService
{
    public function exportUsersFavoritesCsv()
    {
        try {
            $fileName = 'users_favorites_report_' . date('Y_m_d_H_i_s') . '.csv';
            $filePath = storage_path("app/public/reports/$fileName");

            if (!file_exists(dirname($filePath))) {
                mkdir(dirname($filePath), 0777, true);
            }

            $users = User::withCount('favorites')->get();

            $file = fopen($filePath, 'w');

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

            return response()->download($filePath, $fileName)->deleteFileAfterSend(false);
        } catch (\Throwable $e) {
            Log::error('CSV export failed', ['error' => $e->getMessage()]);
            throw new ExportFailedException('Failed to export favorites CSV.');
        }
    }
}
