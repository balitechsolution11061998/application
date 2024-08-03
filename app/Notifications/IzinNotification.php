<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IzinNotification extends Notification
{
    use Queueable;

    private $izin;

    public function __construct($izin)
    {
        $this->izin = $izin;
    }

    public function via($notifiable)
    {
        return ['mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Izin Request Submitted')
            ->line('A new izin request has been submitted.')
            ->line('Employee NIK: ' . $this->izin->nik)
            ->line('Leave Type: ' . $this->izin->kode_izin)
            ->line('From: ' . $this->izin->tgl_izin_dari)
            ->line('To: ' . $this->izin->tgl_izin_sampai)
            ->line('Status: ' . $this->izin->status)
            ->line('Keterangan: ' . $this->izin->keterangan)
            ->action('View Izin', url('/izins/' . $this->izin->id))
            ->line('Thank you for using our application!');
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'New Izin request for ' . $this->izin->kode_izin,
            'izin_id' => $this->izin->id,
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'New Izin request for ' . $this->izin->kode_izin,
            'izin_id' => $this->izin->id,
        ];
    }
}
