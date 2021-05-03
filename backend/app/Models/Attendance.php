<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'check_in', 'check_out'];

    protected $appends = ['duration'];

    public function getDurationAttribute()
    {
        $checkIn = new DateTime($this->check_in);

        $checkOut = $this->check_out ?? date('Y-m-d H:i:s', strtotime('17:00'));
        $checkOut = new DateTime($checkOut);

        $diff = $checkIn->diff($checkOut);

        return $diff->format('%H:%I:%S');
    }
}
