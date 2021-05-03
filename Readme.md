# Simple Attendance System

## Introduction

> This is a simple attendance system which is developed by Laravel and Vue JS framework. There are multiple branches and multiple employees in each branch. Here every employee can attend more than once a day. Whenever an employee checks, then an email goes to his manager. Every day at 9:00 pm, the employees should receive their work summary via email.

## Code Samples

> Here I have used Laravel scheduler for send mail to employees every day at 9:00 pm. Also, I have used Laravel queue for a better user experience.

```
// app/Repositories/AttendanceRepository.php

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


// app/Console/Kernel.php

/**
    * Define the application's command schedule.
    *
    * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
    * @return void
    */
protected function schedule(Schedule $schedule)
{
    // $schedule->command('inspire')->hourly();

    $schedule->job(new SendEmployeeDailyAttendanceList)->dailyAt('21:00');
}
```





## Installation

> Backend
- cd backend
- composer install
- .env.example rename to .env
- php artisan key:generate (run this command)
- configure your database and mail
- php artisan migrate (create database tables)
- php artisan serve (run server)
- php artisan queue:work (run this command for mail queue)
- php artisan schedule:work (run this command for shceduler)

> Frontend
- cd frontend
- npm install
- go to browser and enter http://localhost:8080
- **username:** admin **password:** 1
