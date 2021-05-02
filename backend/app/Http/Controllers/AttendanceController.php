<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;

class AttendanceController extends Controller
{
    private $attendanceRepo;

    public function __construct(AttendanceRepository $attendanceRepo)
    {
        $this->attendanceRepo = $attendanceRepo;
    }

    public function receiveAttendance()
    {
        $res = $this->attendanceRepo->add();
        
        return response()->json([
            'message' => $res->message,
            'check_in' => $res->willCheckIn,
        ], $res->code);
    }

    public function willCheckIn()
    {
        $checkIn = $this->attendanceRepo->willCheckIn();
        return response()->json(['check_in' => $checkIn]);
    }
}
