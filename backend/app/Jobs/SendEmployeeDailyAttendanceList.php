<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\EmployeeDailyAttendanceList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmployeeDailyAttendanceList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $employees = User::with('todaysAttendances')->get();

        if ($employees->count()) {
            foreach ($employees as $employee) {
                if ($employee->todaysAttendances()->count()) {
                    Mail::to($employee->email)->send(new EmployeeDailyAttendanceList($employee));
                }
            }
        }
    }
}
