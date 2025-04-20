<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseApiController
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->with(['driver', 'vehicle'])->latest()->paginate(10);
        return $this->successResponse($bookings);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_location' => ['required', 'string'],
            'pickup_latitude' => ['required', 'numeric'],
            'pickup_longitude' => ['required', 'numeric'],
            'destination_location' => ['required', 'string'],
            'destination_latitude' => ['required', 'numeric'],
            'destination_longitude' => ['required', 'numeric'],
            'driver_id' => ['required', 'exists:drivers,id'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'patient_name' => ['required', 'string'],
            'patient_phone' => ['required', 'string'],
            'emergency_contact' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $booking = $request->user()->bookings()->create($request->all());

        return $this->createdResponse($booking->load(['driver', 'vehicle']));
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return $this->successResponse($booking->load(['driver', 'vehicle']));
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        if ($booking->status !== 'pending' && $booking->status !== 'accepted') {
            return $this->errorResponse('Cannot cancel this booking');
        }

        $booking->update(['status' => 'cancelled']);

        return $this->successResponse($booking, 'Booking cancelled successfully');
    }

    public function nearbyDrivers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'radius' => ['sometimes', 'numeric', 'min:1', 'max:50'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $radius = $request->get('radius', 10); // Default 10km radius

        $drivers = Driver::available()
            ->selectRaw(
                '*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance',
                [$request->latitude, $request->longitude, $request->latitude]
            )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->with('vehicle')
            ->get();

        return $this->successResponse($drivers);
    }

    public function nearbyHospitals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'radius' => ['sometimes', 'numeric', 'min:1', 'max:50'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        $radius = $request->get('radius', 10); // Default 10km radius

        $hospitals = Hospital::selectRaw(
            '*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance',
            [$request->latitude, $request->longitude, $request->latitude]
        )
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        return $this->successResponse($hospitals);
    }

    public function emergencySos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'location' => ['required', 'string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first());
        }

        // Find nearest available driver
        $driver = Driver::available()
            ->selectRaw(
                '*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude) - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance',
                [$request->latitude, $request->longitude, $request->latitude]
            )
            ->orderBy('distance')
            ->first();

        if (!$driver) {
            return $this->errorResponse('No available drivers found nearby');
        }

        // Create emergency booking
        $booking = $request->user()->bookings()->create([
            'driver_id' => $driver->id,
            'pickup_location' => $request->location,
            'pickup_latitude' => $request->latitude,
            'pickup_longitude' => $request->longitude,
            'notes' => $request->description,
            'is_emergency' => true,
            'status' => 'accepted',
        ]);

        return $this->createdResponse($booking->load(['driver', 'vehicle']), 'Emergency SOS sent successfully');
    }
}