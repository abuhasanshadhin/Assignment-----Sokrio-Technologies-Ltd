<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeeChecksNotificationForManager extends Notification implements ShouldQueue
{
    use Queueable;

    private $checks;
    private $time;
    private $employee;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($checks, $time, $employee)
    {
        $this->checks = $checks;
        $this->time = $time;
        $this->employee = $employee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $checks = $this->checks == 'in' ? 'in' : 'out';

        return (new MailMessage)
            ->line("{$this->employee->name} checked {$checks}.")
            ->line("E-Mail Address : {$this->employee->email}")
            ->line("Check {$checks} time : {$this->time}")
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
