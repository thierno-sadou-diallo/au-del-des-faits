<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCreated extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle demande de rendez-vous')
            ->greeting('Nouvelle demande de rendez-vous reçue!')
            ->line('**' . $this->appointment->name . '** a demandé un rendez-vous.')
            ->line('')
            ->line('**Détails de la demande:**')
            ->line('- **Email:** ' . $this->appointment->email)
            ->line('- **Téléphone:** ' . ($this->appointment->phone ?? 'Non fourni'))
            ->line('- **Organisation:** ' . ($this->appointment->organization ?? 'Non fournie'))
            ->line('- **Date du rendez-vous:** ' . $this->appointment->availabilitySlot->start_time->format('d/m/Y H:i') . ' à ' . $this->appointment->availabilitySlot->end_time->format('H:i'))
            ->line('- **Objet:** ' . $this->appointment->subject)
            ->line('')
            ->line('**Message:**')
            ->line($this->appointment->message)
            ->action('Consulter la demande', url('/admin/appointments/' . $this->appointment->id))
            ->line('Merci!')
            ->salutation("Cordialement,\nL'équipe d'Au-delà des faits");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'name' => $this->appointment->name,
            'email' => $this->appointment->email,
            'subject' => $this->appointment->subject,
            'start_time' => $this->appointment->availabilitySlot?->start_time?->toIso8601String(),
        ];
    }
}
