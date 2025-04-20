<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function getUser(){
        $user = User::all();
        return view('manage-users.index', compact('user'));
    }

    public function getDriver(){
        $driver = Driver::all();
        return view('manage-drivers.index', compact('driver'));
    }

    public function getBooking(){
        $booking = Booking::all();
        return view('booking-history.index', compact('booking'));
    }
}
