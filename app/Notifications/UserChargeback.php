<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserChargeback extends Notification
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
                    ->subject("Contato - {$this->course->name} - chargeback | EspecializaTi")
                    ->line('Olá, tudo bem?')
                    ->line('Aqui quem fala é o Carlos Ferreira!')
                    ->line('O Hotmart me notificou do chargeback do curso, isso é muito ruim para a empresa.')
                    ->line('Eu gostaria de receber um feedback sincero seu. Por que fez isso?')
                    ->line('Eu tenho um filho de 2 anos, e sustento minha família com as vendas deste curso (especialmente este), e esse feedback é muito importante para mim.')
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
