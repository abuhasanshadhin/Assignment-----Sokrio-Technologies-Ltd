<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeDailyAttendanceList extends Mailable
{
    use Queueable, SerializesModels;

    private $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $employee = $this->employee;

        return $this->view('mail.employee-daily-attendance-list', compact('employee'))
            ->subject("Today's Attendance List")
            ->from('info@sokrio.com');
    }
}
