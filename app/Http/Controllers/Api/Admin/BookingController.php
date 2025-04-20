<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends BaseApiController
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['user', 'driver', 'vehicle', 'hospital'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('driver', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('pickup_location', 'like', "%{$search}%")
                    ->orWhere('destination_location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return $this->successResponse($bookings);
    }

    public function show(Booking $booking)
    {
        return $this->successResponse($booking->load(['user', 'driver', 'vehicle', 'hospital']));
    }

    public function update(Request $request, Booking $booking)
    {
        $validStatuses = ['pending', 'accepted', 'completed', 'cancelled'];
        
        if ($request->has('status') && !in_array($request->status, $validStatuses)) {
            return $this->errorResponse('Invalid status');
        }

        $booking->update($request->only(['status', 'notes']));

        return $this->successResponse($booking, 'Booking updated successfully');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return $this->noContentResponse();
    }

    public function dashboardStats()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'today_bookings' => Booking::whereDate('created_at', today())->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'completed_bookings' => Booking::where('status', 'completed')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
            'revenue' => [
                'total' => Booking::where('status', 'completed')->sum('amount'),
                'today' => Booking::where('status', 'completed')
                    ->whereDate('created_at', today())
                    ->sum('amount'),
            ],
            'monthly_stats' => Booking::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_bookings'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_bookings'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN amount ELSE 0 END) as revenue')
            )
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get()
        ];

        return $this->successResponse($stats);
    }
}