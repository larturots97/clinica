<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermisosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permisos por módulo
        $permisos = [
            // Pacientes
            'ver-pacientes',
            'crear-pacientes',
            'editar-pacientes',
            'eliminar-pacientes',

            // Médicos
            'ver-medicos',
            'crear-medicos',
            'editar-medicos',
            'eliminar-medicos',

            // Citas
            'ver-citas',
            'crear-citas',
            'editar-citas',
            'cancelar-citas',

            // Historial
            'ver-historial',
            'crear-historial',
            'editar-historial',

            // Recetas
            'ver-recetas',
            'crear-recetas',
            'imprimir-recetas',

            // Facturación
            'ver-facturas',
            'crear-facturas',
            'anular-facturas',

            // Inventario
            'ver-inventario',
            'crear-productos',
            'editar-stock',

            // Estética
            'ver-estetica',
            'crear-tratamientos',
            'editar-mapa-facial',

            // Roles
            'ver-roles',
            'crear-roles',
            'editar-roles',
            'asignar-permisos',

            // Reportes
            'ver-reportes',
            'exportar-reportes',

            // Auditoría
            'ver-auditoria',
        ];

        // Crear permisos
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // Crear roles y asignar permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $medico = Role::firstOrCreate(['name' => 'medico']);
        $medico->syncPermissions([
            'ver-pacientes', 'editar-pacientes',
            'ver-citas', 'crear-citas', 'editar-citas',
            'ver-historial', 'crear-historial', 'editar-historial',
            'ver-recetas', 'crear-recetas', 'imprimir-recetas',
            'ver-estetica', 'crear-tratamientos', 'editar-mapa-facial',
            'ver-reportes',
        ]);

        $enfermera = Role::firstOrCreate(['name' => 'enfermera']);
        $enfermera->syncPermissions([
            'ver-pacientes',
            'ver-citas', 'editar-citas',
            'ver-historial', 'crear-historial',
        ]);

        $recepcionista = Role::firstOrCreate(['name' => 'recepcionista']);
        $recepcionista->syncPermissions([
            'ver-pacientes', 'crear-pacientes', 'editar-pacientes',
            'ver-citas', 'crear-citas', 'editar-citas', 'cancelar-citas',
            'ver-facturas', 'crear-facturas',
        ]);

        $farmacia = Role::firstOrCreate(['name' => 'farmacia']);
        $farmacia->syncPermissions([
            'ver-inventario', 'crear-productos', 'editar-stock',
            'ver-recetas',
        ]);

        $paciente = Role::firstOrCreate(['name' => 'paciente']);
        $paciente->syncPermissions([
            'ver-citas',
            'ver-recetas',
            'ver-facturas',
        ]);

        $this->command->info('Roles y permisos creados exitosamente.');
    }
}