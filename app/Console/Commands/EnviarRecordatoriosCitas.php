<?php

namespace App\Console\Commands;

use App\Models\Cita;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarRecordatoriosCitas extends Command
{
    protected $signature   = 'citas:recordatorios';
    protected $description = 'Envía recordatorios de citas del día siguiente por correo';

    public function handle()
    {
        $manana = now()->addDay()->toDateString();

        $citas = Cita::with(['paciente', 'medico'])
            ->whereDate('fecha_hora', $manana)
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->where('recordatorio_enviado', false)
            ->get();

        $this->info("Citas encontradas para mañana: {$citas->count()}");

        foreach ($citas as $cita) {
            // Correo
            if ($cita->email_paciente) {
                try {
                    Mail::send('emails.cita-recordatorio', ['cita' => $cita], function ($m) use ($cita) {
                        $m->to($cita->email_paciente, $cita->paciente->nombre)
                          ->subject('Recordatorio: Su cita es mañana');
                    });
                    $this->info("Correo enviado a: {$cita->email_paciente}");
                } catch (\Exception $e) {
                    $this->error("Error enviando correo a {$cita->email_paciente}: {$e->getMessage()}");
                }
            }

            // Marcar recordatorio como enviado
            $cita->update(['recordatorio_enviado' => true]);
        }

        $this->info('Recordatorios procesados correctamente.');
        return 0;
    }
}
