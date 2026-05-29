<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $slot = $this->appointment->availabilitySlot;
        $when = $slot ? $slot->start_time->format('d/m/Y H:i') . ' - ' . $slot->end_time->format('H:i') : 'à définir';

        return (new MailMessage)
            ->subject('Votre rendez-vous est confirmé')
            ->greeting('Bonjour ' . $this->appointment->name . ',')
            ->line('Votre demande de rendez-vous a été confirmée.')
            ->line('Date et heure: ' . $when)
            ->line('Objet: ' . $this->appointment->subject)
            ->action('Suivre ma demande', route('appointment.status.show', $this->appointment->tracking_token))
            ->line('Merci.')
            ->salutation("Cordialement,\nL'équipe d'Au-delà des faits");
    }

    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'status' => $this->appointment->status,
            'start_time' => $this->appointment->availabilitySlot?->start_time?->toIso8601String(),
        ];
    }
}
