<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Clinica;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Crear clínica principal
        $clinica = Clinica::firstOrCreate(
            ['nombre' => 'Clínica Principal'],
            [
                'direccion' => 'Av. Principal #123',
                'telefono'  => '667-123-4567',
                'email'     => 'contacto@clinica.com',
                'activo'    => true,
            ]
        );

        // Crear usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@clinica.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password123'),
            ]
        );

        // Asignar rol admin
        $admin->assignRole('admin');

        $this->command->info('Admin creado: admin@clinica.com / password123');
    }
}