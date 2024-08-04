<?php

namespace App\Notifications;

use App\Models\Izin;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class IzinRequestNotification extends Notification
{
    use Queueable;

    protected $izin;

    public function __construct(Izin $izin)
    {
        $this->izin = $izin;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Leave Request')
            ->line('A new leave request has been submitted.')
            ->line('Kode Izin: ' . $this->izin->kode_izin)
            ->line('NIK: ' . $this->izin->nik)
            ->line('Tanggal Izin Dari: ' . $this->izin->tgl_izin_dari)
            ->line('Tanggal Izin Sampai: ' . $this->izin->tgl_izin_sampai)
            ->line('Keterangan: ' . $this->izin->keterangan)
            ->action('View Leave Request', url('/izin/' . $this->izin->id))
            ->line('Thank you for using our application!');
    }
}
