<?php

namespace App\Notifications;

use App\Models\{
    Course,
    User
};
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserCreated extends Notification
{
    use Queueable;

    private $password = '';
    private $course;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(String $password, User $user, Course $course)
    {
        $this->password = $password;
        $this->user = $user;
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
                    ->subject('Dados de Acesso - EspecializaTi')
                    ->line("Olá, {$this->user->name}!")
                    ->line('Segue os seus dados de acesso ao campus ead! :)')
                    ->line("E-mail: {$this->user->email}")
                    ->line("Senha: {$this->password}")
                    ->action("Acessar o {$this->course->name}", url(env('URL_CAMPUS_ETI')))
                    ->line('Ótimos estudos!');
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
