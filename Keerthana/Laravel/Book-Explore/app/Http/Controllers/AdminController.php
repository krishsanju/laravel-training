<?php

namespace App\Http\Controllers;

use TCPDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Response\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Services\ExportService;
use App\Services\ReviewService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\FavoriteService;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ExportFailedException;
use App\Exceptions\ActionNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class AdminController extends Controller
{
    protected FavoriteService $favoriteService;
    protected ReviewService $reviewService;
    protected UserService $userService;

    public function __construct(FavoriteService $favoriteService, ReviewService $reviewService, UserService $userService, private ExportService $exportService)
    {
        $this->favoriteService = $favoriteService;
        $this->reviewService = $reviewService;
        $this->userService = $userService;
    }
    public function users()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            throw new ResourceNotFoundException('No users found.');
        }

        return ApiResponse::setMessage('Users fetched successfully')
            ->setData($users)
            ->response(Response::HTTP_OK);
    }

    // public function destroy($idToDelete, Request $request)
    // {
    //     $authUser = $request->id;
    //     info($authUser);
    //     info($idToDelete);
    //     if( $authUser === $idToDelete){
    //         return ApiResponse::setMessage('You cannot delete your own account')
    //                 ->response(Response::HTTP_FORBIDDEN);
    //     }

    //     $user = User::find($idToDelete);

    //     if(!$user){
    //         return ApiResponse::setMessage('User not found')
    //             ->response(Response::HTTP_NOT_FOUND);
    //     }

    //     $user->delete();

    //     return Apiresponse::setMessage('User deleted successfully')
    //         ->response(Response::HTTP_OK);

    // }

    public function getAllFavorites()
    {
        $favorites = $this->favoriteService->getAllFavorites();

        if ($favorites->isEmpty()) {
            throw new ResourceNotFoundException('No favorites found.');
        }

        return ApiResponse::setMessage('All users favorite books')
            ->setData($favorites)
            ->response(Response::HTTP_OK);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'book_id' => 'required|integer|exists:books,id',
        ]);

        $removed = $this->reviewService->removeReview($request->user_id, $request->book_id);

        if (!$removed) {
            throw new ResourceNotFoundException('Review not found for this user and book.');
        }

        return ApiResponse::setMessage('Review removed')
            ->response(Response::HTTP_OK);
    }

    public function activity(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer|exists:users,id'
        ]);

        $logs = ($request->query('id')) ? $this->userService->getActivityLogs($request->query('id'))
            : $this->userService->getAllActivityLogs();

        if (empty($logs)) {
            throw new ResourceNotFoundException('No activity logs found.');
        }

        return ApiResponse::setMessage('Activity logs fetched')
            ->setData($logs)
            ->response(Response::HTTP_OK);
    }

    public function blockUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = $this->userService->blockUser($request->user_id);

        if (!$user) {
            throw new ResourceNotFoundException('User not found.');
        }
        // if ($user->is_blocked) {
        //     throw new ActionNotAllowedException('User is already blocked.');
        // }

        return ApiResponse::setMessage('User is blocked')
            ->setData($user)
            ->response(Response::HTTP_OK);
    }

    public function exportUsersFavoritesCsv()
    {
        return $this->exportService->exportUsersFavoritesCsv();
    }

    public function monthlyFavoritesPdf()
    {
        $data = User::with(['favorites' => function ($q) {
            $q->whereYear('favorites.created_at', Carbon::now()->year)
                ->selectRaw('user_id, MONTH(created_at) as month, COUNT(*) as total')
                ->groupBy('user_id', 'month');
        }])->get();

        if ($data->isEmpty()) {
            throw new ExportFailedException('No user data available for PDF report.');
        }

        $pdf = Pdf::loadView('reports.monthlyFavorites', compact(var_name: 'data'));


        $filename = 'Pdfs/favorites_report_' . Str::uuid() . '.pdf';
        $pdfContent = $pdf->output();
        Storage::disk('public')->put($filename, $pdfContent);

        return $pdf->download('favorites_report_' . date('Y_m_d') . '.pdf');
    }
}
