<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendExamNotificationToUser extends Notification
{
    use Queueable;

    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->line('New Message From "' . $this->data_send['from_user'] . '"')
    //         ->action('Message Action', url('/message'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->data['user_id'],
            'package_id' => !empty($this->data['package_id']) ? $this->data['package_id'] : '',
            'main_mcq_id' => !empty($this->data['main_mcq_id']) ? $this->data['main_mcq_id'] : '',
            'message' => !empty($this->data['message']) ? $this->data['message'] : '',
            'admin_id' => !empty($this->data['admin_id']) ? $this->data['admin_id'] : '',
        ];
    }
}
