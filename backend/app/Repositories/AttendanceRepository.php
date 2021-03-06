<?php

namespace App\Repositories;

use App\Models\Attendance;
use App\Notifications\EmployeeChecksNotificationForManager;
use Exception;
use Illuminate\Support\Facades\Auth;
use stdClass;

class AttendanceRepository
{
    public function add()
    {
        $res = new stdClass;

        try {

            if (time() < strtotime('7:45 AM')) {
                $res->message = 'Cannot check-in before 7:45 am';
                $res->code = 403;
            } else {

                $status = "";

                $lastAttendance = Attendance::whereDate('check_in', date('Y-m-d'))
                    ->where('employee_id', Auth::user()->id)
                    ->latest()
                    ->first();

                $manager = Auth::user()->branch->users()->where('role', 'manager')->first();

                if ($lastAttendance && $lastAttendance->check_out == null) {
                    $dateTime = date('Y-m-d H:i:s');
                    $lastAttendance->update(['check_out' => date('Y-m-d H:i:s')]);
                    $status = 'Checked Out';

                    $manager->notify(new EmployeeChecksNotificationForManager('out', $dateTime, Auth::user()));

                } else {
                    $attendance = new Attendance();
                    $data['employee_id'] = Auth::user()->id;
                    $data['check_in'] = date('Y-m-d H:i:s');
                    $attendance->create($data);
                    $status = 'Checked In';

                    $manager->notify(new EmployeeChecksNotificationForManager('in', $data['check_in'], Auth::user()));
                }

                $res->message = "You are successfully {$status}";
                $res->code = 200;
            }

        } catch (Exception $e) {
            $res->message = $e->getMessage();
            $res->code = 500;
        }

        $res->willCheckIn = $this->willCheckIn();
        return $res;
    }

    public function willCheckIn()
    {
        $lastAttendance = Attendance::whereDate('check_in', date('Y-m-d'))
            ->where('employee_id', Auth::user()->id)
            ->latest()
            ->first();

        if ($lastAttendance && $lastAttendance->check_out == null) {
            return false;
        }

        return true;
    }
}
