<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Attendance List</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .heading {
            text-align: center;
            margin-bottom: 10px;

        }

        .branch {
            text-align: center;
            margin-bottom: 8px;
        }

        .emp-name {
            text-align: center;
            margin-bottom: 5px;
            font-size: 18px;
            text-decoration: underline;
        }

        .emp-email {
            text-align: center;
            margin-bottom: 7px;
            font-size: 17px;
        }

        .date {
            text-align: center;
            color: rgb(3, 3, 241);
            font-size: 19px;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: center;
        }

        .table th,
        .table td {
            border: 1px solid #636262;
            padding: 2px 5px;
            font-size: 17px;
        }

    </style>
</head>

<body>
    <h2 class="heading">Today's Attendance List</h2>
    <h3 class="branch">{{ optional($employee->branch)->name }} Branch</h3>
    <p class="emp-name">{{ $employee->name }}</p>
    <p class="emp-email">{{ $employee->email }}</p>
    <p class="date">{{ date('D d M, Y') }}</p>

    <table class="table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Duration</th>
            </tr>
        </thead>
        <tbody>
            @php
                $times = [];
            @endphp

            @foreach ($employee->todaysAttendances as $attendance)
                @php
                    $times[] = $attendance->duration;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('h:i:s A', strtotime($attendance->check_in)) }}</td>
                    <td>{{ date('h:i:s A', strtotime($attendance->check_out)) }}</td>
                    <td>{{ $attendance->duration }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right">Total = </td>
                <td>
                    @php
                        $sum = strtotime('00:00:00');

                        $totaltime = 0;

                        foreach ($times as $time) {
                            $timeinsec = strtotime($time) - $sum;
                            $totaltime = $totaltime + $timeinsec;
                        }

                        $h = intval($totaltime / 3600);
                        $totaltime = $totaltime - $h * 3600;
                        $m = intval($totaltime / 60);
                        $s = $totaltime - $m * 60;

                        echo "$h:$m:$s";
                    @endphp
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
