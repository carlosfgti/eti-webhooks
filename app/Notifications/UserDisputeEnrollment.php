<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserDisputeEnrollment extends Notification
{
    use Queueable;

    private $course;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
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
        return (new MailMessage)
                    ->cc('carlos@especializati.com.br')
                    ->subject("Contato - {$this->course->name} - reembolso | EspecializaTi")
                    ->line('Olá, tudo bem?')
                    ->line('Aqui quem fala é o Carlos Ferreira!')
                    ->line("O Hotmart me notificou que você solicitou o reembolso do {$this->course->name}")
                    ->line('Eu gostaria de receber um feedback sincero seu. Por que fez isso?')
                    ->line('Esse feedback é muito importante para mim melhorar a qualidade dos produtos.')
                    ->line('No Aguardo! :)');
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
