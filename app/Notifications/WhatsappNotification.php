<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class WhatsappNotification extends Notification
{
    use Queueable;

    private $message;
    private $contact;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $message, $contact)
    {
        $this->message = $message;
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['whatsapp'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toWhatsapp($notifiable)
    {
        $client = new Client();
        $client->post('https://go.botmaker.com/api/v1.0/message/v3', [
            "body" => [
                "chatPlatform" => "whatsapp",
                "chatChannelNumber" => "573152631371",
                "platformContactId" => $this->contact,
                "messageText" => $this->message
            ],
            "header" => [
                "access-token" => "eyJhbGciOiJIUzUxMiJ9.eyJidXNpbmVzc0lkIjoiTGluZXJ1IiwibmFtZSI6Ikp1YW4gUm96byIsImFwaSI6dHJ1ZSwiaWQiOiJVS0RSMmVvcjNJYVF3MUs3eUhrdTBwOTFyOWgxIiwiZXhwIjoxNzI2MzI2MjQ2LCJqdGkiOiJVS0RSMmVvcjNJYVF3MUs3eUhrdTBwOTFyOWgxIn0.0Rn8Gve5X2r-9Yq8vjyYVfRXjRzgc_BOnzppiZpUQOTLOakQL3G3n7rQdoC62gE8lquEFwqHFXNStGK94kPNGg",
                "Content-Type" => "application/json"
            ]
        ]);
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
