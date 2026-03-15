@extends('layouts.medico')

@section('titulo', 'Configuraciones')

@section('contenido')
@php
    $diasNombres = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $tab = request('tab', 'clinica');
@endphp

<div style="padding:1.5rem 2rem; background:#f8fafc; min-height:100vh;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
        <div>
            <h1 style="font-size:1.6rem; font-weight:700; color:#0f172a; margin:0;">Configuraciones</h1>
            <p style="color:#64748b; font-size:0.875rem; margin-top:0.25rem;">
                Personaliza los datos de tu clínica, horario de atención y cuenta
            </p>
        </div>
    </div>

    {{-- Pestañas --}}
    <div style="display:flex;gap:4px;background:#f1f5f9;border-radius:12px;padding:4px;margin-bottom:1.5rem;width:fit-content;">
        <a href="?tab=clinica" style="display:flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;{{ $tab==='clinica' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
            <i class="fas fa-hospital-alt"></i> Clínica
        </a>
        <a href="?tab=medico" style="display:flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;{{ $tab==='medico' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
            <i class="fas fa-user-md"></i> Datos del Médico
        </a>
        <a href="?tab=horario" style="display:flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;{{ $tab==='horario' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
            <i class="fas fa-clock"></i> Horario
        </a>
        <a href="?tab=receta" style="display:flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;{{ $tab==='receta' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
            <i class="fas fa-prescription"></i> Receta
        </a>
        <a href="?tab=seguridad" style="display:flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;{{ $tab==='seguridad' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
            <i class="fas fa-lock"></i> Seguridad
        </a>
        <a href="?tab=landing" style="display:flex;align-items:center;gap:6px;padding:8px 18px;border-radius:9px;font-size:13px;font-weight:600;text-decoration:none;{{ $tab==='landing' ? 'background:white;color:#7c3aed;box-shadow:0 1px 4px rgba(0,0,0,.08);' : 'color:#64748b;' }}">
            <i class="fas fa-globe"></i> Landing
        </a>
    </div>

    {{-- ═══════════ TAB: CLÍNICA ═══════════ --}}
    @if($tab === 'clinica')
    <form action="{{ route('medico.configuraciones.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.07); margin-bottom:1.25rem; overflow:hidden;">
            <div style="padding:1rem 1.5rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:0.6rem;">
                <div style="width:28px;height:28px;background:#ede9fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-hospital-alt" style="color:#7c3aed;font-size:12px;"></i>
                </div>
                <span style="font-size:0.95rem; font-weight:600; color:#0f172a;">Datos de la Clínica</span>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Nombre de la clínica</label>
                        <input type="text" name="clinica_nombre" value="{{ old('clinica_nombre', $config->clinica_nombre) }}" placeholder="Ej. Clínica Estética Fernanda"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Dirección</label>
                        <input type="text" name="clinica_direccion" value="{{ old('clinica_direccion', $config->clinica_direccion) }}" placeholder="Av. Principal #123"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Ciudad</label>
                        <input type="text" name="clinica_ciudad" value="{{ old('clinica_ciudad', $config->clinica_ciudad) }}" placeholder="Mazatlán, Sinaloa"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:1rem;">
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Teléfono</label>
                        <input type="text" name="clinica_telefono" value="{{ old('clinica_telefono', $config->clinica_telefono) }}" placeholder="669 123 4567"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Email</label>
                        <input type="email" name="clinica_email" value="{{ old('clinica_email', $config->clinica_email) }}" placeholder="contacto@clinica.com"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
            <div style="background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.07); overflow:hidden;">
                <div style="padding:1rem 1.5rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#dbeafe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-image" style="color:#2563eb;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem; font-weight:600; color:#0f172a;">Logo de la Clínica</span>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    @if($config->logo)
                    <div style="margin-bottom:0.75rem;">
                        <p style="font-size:0.75rem; color:#64748b; margin-bottom:0.4rem;">Logo actual:</p>
                        <img src="{{ Storage::url($config->logo) }}" alt="Logo"
                             style="max-height:80px; max-width:200px; border:1px solid #e2e8f0; border-radius:8px; padding:0.4rem; object-fit:contain; background:#f8fafc;">
                    </div>
                    @endif
                    <div x-data="{ preview: null }"
                         style="border:2px dashed #e2e8f0; border-radius:10px; padding:1.5rem; text-align:center; cursor:pointer; transition:all .2s;"
                         @dragover.prevent="$el.style.borderColor='#7c3aed'; $el.style.background='#faf5ff'"
                         @dragleave="$el.style.borderColor='#e2e8f0'; $el.style.background='transparent'"
                         @drop.prevent="$el.style.borderColor='#e2e8f0'; $el.style.background='transparent'; let f=$event.dataTransfer.files[0]; if(f){let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f);$refs.logoInput.files=$event.dataTransfer.files;}"
                         @click="$refs.logoInput.click()">
                        <template x-if="!preview">
                            <div>
                                <i class="fas fa-cloud-upload-alt" style="font-size:1.8rem; color:#a78bfa; margin-bottom:0.5rem;"></i>
                                <p style="color:#64748b; font-size:0.85rem; margin:0;">Arrastra o <span style="color:#7c3aed; font-weight:600;">selecciona</span> tu logo</p>
                                <p style="color:#94a3b8; font-size:0.75rem; margin-top:0.2rem;">PNG, JPG — máx. 2MB</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <img :src="preview" style="max-height:100px; max-width:220px; border-radius:8px; object-fit:contain; margin:0 auto; display:block;">
                        </template>
                        <input type="file" name="logo" accept="image/*" x-ref="logoInput" style="display:none"
                               @change="let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL($event.target.files[0])">
                    </div>
                </div>
            </div>
            <div style="background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.07); overflow:hidden;">
                <div style="padding:1rem 1.5rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#fce7f3;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-signature" style="color:#be185d;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem; font-weight:600; color:#0f172a;">Firma Digital</span>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    @if($config->firma)
                    <div style="margin-bottom:0.75rem;">
                        <p style="font-size:0.75rem; color:#64748b; margin-bottom:0.4rem;">Firma actual:</p>
                        <img src="{{ Storage::url($config->firma) }}" alt="Firma"
                             style="max-height:70px; max-width:180px; border:1px solid #e2e8f0; border-radius:8px; padding:0.4rem; object-fit:contain; background:#f8fafc;">
                    </div>
                    @endif
                    <div x-data="{ preview: null }"
                         style="border:2px dashed #e2e8f0; border-radius:10px; padding:1.5rem; text-align:center; cursor:pointer; transition:all .2s;"
                         @dragover.prevent="$el.style.borderColor='#be185d'; $el.style.background='#fdf2f8'"
                         @dragleave="$el.style.borderColor='#e2e8f0'; $el.style.background='transparent'"
                         @drop.prevent="$el.style.borderColor='#e2e8f0'; $el.style.background='transparent'; let f=$event.dataTransfer.files[0]; if(f){let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f);$refs.firmaInput.files=$event.dataTransfer.files;}"
                         @click="$refs.firmaInput.click()">
                        <template x-if="!preview">
                            <div>
                                <i class="fas fa-pen-fancy" style="font-size:1.8rem; color:#f9a8d4; margin-bottom:0.5rem;"></i>
                                <p style="color:#64748b; font-size:0.85rem; margin:0;">Arrastra o <span style="color:#be185d; font-weight:600;">selecciona</span> tu firma</p>
                                <p style="color:#94a3b8; font-size:0.75rem; margin-top:0.2rem;">PNG con fondo transparente recomendado</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <img :src="preview" style="max-height:100px; max-width:220px; border-radius:8px; object-fit:contain; margin:0 auto; display:block;">
                        </template>
                        <input type="file" name="firma" accept="image/*" x-ref="firmaInput" style="display:none"
                               @change="let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL($event.target.files[0])">
                    </div>
                </div>
            </div>
        </div>

        <div style="background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,0.07); margin-bottom:1.5rem; overflow:hidden;">
            <div style="padding:1rem 1.5rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#fef9c3;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-file-alt" style="color:#ca8a04;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem; font-weight:600; color:#0f172a;">Acta de Consentimiento Informado</span>
                </div>
                <span style="font-size:0.78rem; color:#64748b;">Edita los 12 puntos que aparecerán en el PDF</span>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    @for($i = 1; $i <= 12; $i++)
                    <div>
                        <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.78rem; font-weight:600; color:#374151; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.4px;">
                            <span style="background:#7c3aed; color:#fff; border-radius:50%; width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; font-size:0.65rem; flex-shrink:0;">{{ $i }}</span>
                            Punto {{ $i }}
                        </label>
                        <textarea name="consentimiento_punto_{{ $i }}" rows="3"
                            placeholder="Escribe el texto del punto {{ $i }}..."
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.82rem;color:#0f172a;resize:vertical;outline:none;box-sizing:border-box;line-height:1.5;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                        >{{ old("consentimiento_punto_$i", $config->{"consentimiento_punto_$i"}) }}</textarea>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; padding-bottom:2rem;">
            <button type="submit"
                style="background:#7c3aed; color:#fff; border:none; padding:0.65rem 1.75rem; border-radius:8px; font-size:0.875rem; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:0.5rem;"
                onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                <i class="fas fa-save"></i> Guardar configuración
            </button>
        </div>
    </form>
    @endif

    {{-- ═══════════ TAB: DATOS DEL MÉDICO ═══════════ --}}
    @if($tab === 'medico')
    <form method="POST" action="{{ route('medico.configuraciones.datos') }}">
        @csrf @method('PUT')
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;max-width:1200px;">
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);padding:1.25rem 1.5rem;grid-column:span 2;">
                <div style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:1rem;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-user" style="color:#7c3aed;"></i> Datos Personales
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Nombre(s) *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $medico->nombre) }}" required
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                        @error('nombre')<span style="color:#e11d48;font-size:11px;">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $medico->apellido_paterno) }}" required
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Apellido Materno</label>
                        <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $medico->apellido_materno) }}"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $medico->telefono) }}"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                </div>
            </div>
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);padding:1.25rem 1.5rem;">
                <div style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:1rem;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-stethoscope" style="color:#7c3aed;"></i> Datos Profesionales
                </div>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Cédula Profesional</label>
                        <input type="text" name="cedula" value="{{ old('cedula', $medico->cedula) }}"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                            onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>
                    <div>
                        <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Especialidad</label>
                        <select name="especialidad_id"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;background:white;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                            <option value="">Sin especialidad</option>
                            @foreach(\App\Models\Especialidad::orderBy('nombre')->get() as $esp)
                            <option value="{{ $esp->id }}" {{ old('especialidad_id', $medico->especialidad_id) == $esp->id ? 'selected' : '' }}>
                                {{ $esp->nombre }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);padding:1.25rem 1.5rem;">
                <div style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:1rem;display:flex;align-items:center;gap:6px;">
                    <i class="fas fa-calendar-check" style="color:#7c3aed;"></i> Configuración de Citas
                </div>
                <div>
                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Duración por defecto *</label>
                    <select name="duracion_cita"
                        style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;color:#0f172a;outline:none;background:white;"
                        onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                        @foreach([15,20,30,45,60,90,120] as $min)
                        <option value="{{ $min }}" {{ old('duracion_cita', $medico->duracion_cita ?? 30) == $min ? 'selected' : '' }}>
                            {{ $min }} minutos
                        </option>
                        @endforeach
                    </select>
                    <p style="font-size:11px;color:#94a3b8;margin-top:6px;"><i class="fas fa-circle-info"></i> Se usa para calcular los slots al agendar citas.</p>
                </div>
            </div>
        </div>
        <div style="display:flex;justify-content:flex-end;margin-top:1.25rem;padding-bottom:1rem;border-top:1px solid #e2e8f0;padding-top:1rem;max-width:1200px;">
            <button type="submit"
                style="background:#7c3aed;color:#fff;border:none;padding:0.6rem 1.5rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:0.5rem;"
                onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                <i class="fas fa-save"></i> Guardar datos
            </button>
        </div>
    </form>
    @endif

    {{-- ═══════════ TAB: HORARIO ═══════════ --}}
    @if($tab === 'horario')
    <form method="POST" action="{{ route('medico.configuraciones.horarios') }}">
        @csrf @method('PUT')
        <div style="max-width:700px;">
            <div style="background:#e0f2fe;border:1px solid #bae6fd;border-radius:10px;padding:12px 16px;margin-bottom:1.25rem;font-size:12px;color:#0369a1;display:flex;gap:8px;">
                <i class="fas fa-circle-info" style="margin-top:2px;flex-shrink:0;"></i>
                <span>Define los días y horarios en que atiendes. Solo se mostrarán horas disponibles al crear una cita.</span>
            </div>
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:0.85rem 1.25rem;border-bottom:1px solid #f1f5f9;background:#f8fafc;">
                    <div style="display:grid;grid-template-columns:40px 1fr 130px 130px;gap:12px;font-size:0.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;">
                        <div></div><div>Día</div><div>Entrada</div><div>Salida</div>
                    </div>
                </div>
                @foreach(range(1,6) as $dia)
                @php $h = $horarios->get($dia); $activo = $h?->activo ?? false; @endphp
                <div style="padding:0.85rem 1.25rem;border-bottom:1px solid #f1f5f9;">
                    <div style="display:grid;grid-template-columns:40px 1fr 130px 130px;gap:12px;align-items:center;">
                        <input type="checkbox" name="dias[]" value="{{ $dia }}" id="dia-{{ $dia }}"
                            onchange="toggleDia({{ $dia }}, this.checked)" {{ $activo ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#7c3aed;cursor:pointer;">
                        <label for="dia-{{ $dia }}" id="label-dia-{{ $dia }}"
                            style="font-size:0.9rem;font-weight:600;color:{{ $activo ? '#0f172a' : '#94a3b8' }};cursor:pointer;">
                            {{ $diasNombres[$dia] }}
                        </label>
                        <input type="time" name="hora_inicio[{{ $dia }}]" id="inicio-{{ $dia }}"
                            value="{{ $h?->hora_inicio ?? '09:00' }}" {{ !$activo ? 'disabled' : '' }}
                            style="padding:0.45rem 0.7rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.85rem;outline:none;width:100%;opacity:{{ $activo ? '1' : '0.4' }};"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                        <input type="time" name="hora_fin[{{ $dia }}]" id="fin-{{ $dia }}"
                            value="{{ $h?->hora_fin ?? '18:00' }}" {{ !$activo ? 'disabled' : '' }}
                            style="padding:0.45rem 0.7rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.85rem;outline:none;width:100%;opacity:{{ $activo ? '1' : '0.4' }};"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>
                @endforeach
                @php $h = $horarios->get(0); $activo = $h?->activo ?? false; @endphp
                <div style="padding:0.85rem 1.25rem;">
                    <div style="display:grid;grid-template-columns:40px 1fr 130px 130px;gap:12px;align-items:center;">
                        <input type="checkbox" name="dias[]" value="0" id="dia-0"
                            onchange="toggleDia(0, this.checked)" {{ $activo ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:#7c3aed;cursor:pointer;">
                        <label for="dia-0" id="label-dia-0"
                            style="font-size:0.9rem;font-weight:600;color:{{ $activo ? '#0f172a' : '#94a3b8' }};cursor:pointer;">Domingo</label>
                        <input type="time" name="hora_inicio[0]" id="inicio-0"
                            value="{{ $h?->hora_inicio ?? '09:00' }}" {{ !$activo ? 'disabled' : '' }}
                            style="padding:0.45rem 0.7rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.85rem;outline:none;width:100%;opacity:{{ $activo ? '1' : '0.4' }};"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                        <input type="time" name="hora_fin[0]" id="fin-0"
                            value="{{ $h?->hora_fin ?? '18:00' }}" {{ !$activo ? 'disabled' : '' }}
                            style="padding:0.45rem 0.7rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.85rem;outline:none;width:100%;opacity:{{ $activo ? '1' : '0.4' }};"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;margin-top:1.25rem;padding-bottom:1rem;">
                <button type="submit"
                    style="background:#7c3aed;color:#fff;border:none;padding:0.65rem 1.75rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.5rem;"
                    onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                    <i class="fas fa-save"></i> Guardar horario
                </button>
            </div>
        </div>
    </form>
    @endif

    {{-- ═══════════ TAB: RECETA ═══════════ --}}
    @if($tab === 'receta')
    <form method="POST" action="{{ route('medico.configuraciones.receta') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div style="background:#faf5ff;border:1px solid #e9d5ff;border-radius:10px;padding:12px 16px;margin-bottom:1.25rem;font-size:12px;color:#7c3aed;display:flex;gap:8px;">
            <i class="fas fa-circle-info" style="margin-top:2px;flex-shrink:0;"></i>
            <span>Esta información aparecerá en el <strong>PDF de recetas</strong>. Aquí puedes subir el logo del encabezado, el logo de fondo (marca de agua) y los datos del footer.</span>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.25rem;max-width:1200px;">
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#ede9fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-image" style="color:#7c3aed;font-size:12px;"></i>
                    </div>
                    <div><span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Logo del encabezado</span>
                    <p style="font-size:0.72rem;color:#94a3b8;margin:1px 0 0;">Aparece en la parte superior del PDF</p></div>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    @if($config->logo)
                    <div style="margin-bottom:0.75rem;"><p style="font-size:0.75rem;color:#64748b;margin-bottom:0.4rem;">Logo actual:</p>
                    <img src="{{ Storage::url($config->logo) }}" style="max-height:70px;max-width:160px;border:1px solid #e2e8f0;border-radius:8px;padding:0.4rem;object-fit:contain;background:#f8fafc;"></div>
                    @endif
                    <div x-data="{ preview: null }" style="border:2px dashed #e2e8f0;border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s;"
                         @dragover.prevent="$el.style.borderColor='#7c3aed';$el.style.background='#f5f3ff'"
                         @dragleave="$el.style.borderColor='#e2e8f0';$el.style.background='transparent'"
                         @drop.prevent="$el.style.borderColor='#e2e8f0';$el.style.background='transparent';let f=$event.dataTransfer.files[0];if(f){let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f);$refs.logoHeaderInput.files=$event.dataTransfer.files;}"
                         @click="$refs.logoHeaderInput.click()">
                        <template x-if="!preview"><div><i class="fas fa-cloud-upload-alt" style="font-size:1.8rem;color:#a78bfa;margin-bottom:0.5rem;"></i>
                        <p style="color:#64748b;font-size:0.85rem;margin:0;">Arrastra o <span style="color:#7c3aed;font-weight:600;">selecciona</span></p></div></template>
                        <template x-if="preview"><img :src="preview" style="max-height:90px;max-width:200px;border-radius:8px;object-fit:contain;margin:0 auto;display:block;"></template>
                        <input type="file" name="logo" accept="image/*" x-ref="logoHeaderInput" style="display:none"
                               @change="let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL($event.target.files[0])">
                    </div>
                </div>
            </div>
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#fef3c7;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-water" style="color:#d97706;font-size:12px;"></i>
                    </div>
                    <div><span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Logo de fondo (marca de agua)</span>
                    <p style="font-size:0.72rem;color:#94a3b8;margin:1px 0 0;">Aparece semitransparente detrás del contenido</p></div>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    @if($config->receta_logo_fondo)
                    <div style="margin-bottom:0.75rem;"><p style="font-size:0.75rem;color:#64748b;margin-bottom:0.4rem;">Logo de fondo actual:</p>
                    <img src="{{ Storage::url($config->receta_logo_fondo) }}" style="max-height:70px;max-width:160px;border:1px solid #e2e8f0;border-radius:8px;padding:0.4rem;object-fit:contain;background:#f8fafc;opacity:.5;"></div>
                    @endif
                    <div x-data="{ preview: null }" style="border:2px dashed #e2e8f0;border-radius:10px;padding:1.5rem;text-align:center;cursor:pointer;transition:all .2s;"
                         @dragover.prevent="$el.style.borderColor='#d97706';$el.style.background='#fffbeb'"
                         @dragleave="$el.style.borderColor='#e2e8f0';$el.style.background='transparent'"
                         @drop.prevent="$el.style.borderColor='#e2e8f0';$el.style.background='transparent';let f=$event.dataTransfer.files[0];if(f){let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f);$refs.fondoInput.files=$event.dataTransfer.files;}"
                         @click="$refs.fondoInput.click()">
                        <template x-if="!preview"><div><i class="fas fa-cloud-upload-alt" style="font-size:1.8rem;color:#fbbf24;margin-bottom:0.5rem;"></i>
                        <p style="color:#64748b;font-size:0.85rem;margin:0;">Arrastra o <span style="color:#d97706;font-weight:600;">selecciona</span></p></div></template>
                        <template x-if="preview"><img :src="preview" style="max-height:90px;max-width:200px;border-radius:8px;object-fit:contain;margin:0 auto;display:block;opacity:.5;"></template>
                        <input type="file" name="receta_logo_fondo" accept="image/*" x-ref="fondoInput" style="display:none"
                               @change="let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL($event.target.files[0])">
                    </div>
                </div>
            </div>
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#dcfce7;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-address-card" style="color:#16a34a;font-size:12px;"></i>
                    </div>
                    <div><span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Datos del footer</span>
                    <p style="font-size:0.72rem;color:#94a3b8;margin:1px 0 0;">Aparecen en la franja inferior de la receta</p></div>
                </div>
                <div style="padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:1rem;">
                    <div>
                        <label style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fas fa-map-marker-alt" style="color:#94a3b8;"></i> Dirección</label>
                        <input type="text" name="receta_direccion" value="{{ old('receta_direccion', $config->receta_direccion) }}" placeholder="C. Velázquez 19"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div>
                        <label style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fab fa-instagram" style="color:#e1306c;"></i> Instagram</label>
                        <div style="display:flex;align-items:center;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                            <span style="padding:0 10px;font-size:0.875rem;color:#94a3b8;background:#f8fafc;border-right:1px solid #e2e8f0;height:100%;display:flex;align-items:center;">@</span>
                            <input type="text" name="receta_instagram" value="{{ old('receta_instagram', $config->receta_instagram) }}" placeholder="dra.fernanda"
                                style="flex:1;padding:0.55rem 0.85rem;border:none;font-size:0.875rem;outline:none;">
                        </div>
                    </div>
                    <div>
                        <label style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fab fa-facebook" style="color:#1877f2;"></i> Facebook</label>
                        <div style="display:flex;align-items:center;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                            <span style="padding:0 10px;font-size:0.875rem;color:#94a3b8;background:#f8fafc;border-right:1px solid #e2e8f0;height:100%;display:flex;align-items:center;">@</span>
                            <input type="text" name="receta_facebook" value="{{ old('receta_facebook', $config->receta_facebook) }}" placeholder="dra.fernanda"
                                style="flex:1;padding:0.55rem 0.85rem;border:none;font-size:0.875rem;outline:none;">
                        </div>
                    </div>
                    <div>
                        <label style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fab fa-whatsapp" style="color:#25d366;"></i> WhatsApp</label>
                        <input type="text" name="receta_whatsapp" value="{{ old('receta_whatsapp', $config->receta_whatsapp) }}" placeholder="33 2047 1184"
                            style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                </div>
            </div>
            <div style="grid-column:span 3;display:flex;justify-content:flex-end;padding-bottom:1rem;">
                <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.65rem 1.75rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.5rem;"
                    onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                    <i class="fas fa-save"></i> Guardar configuración de receta
                </button>
            </div>
        </div>
    </form>
    @endif

    {{-- ═══════════ TAB: SEGURIDAD ═══════════ --}}
    @if($tab === 'seguridad')
    <form method="POST" action="{{ route('medico.configuraciones.password') }}" style="max-width:440px;">
        @csrf @method('PUT')
        <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);padding:1.25rem 1.5rem;">
            <div style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:1rem;display:flex;align-items:center;gap:6px;">
                <i class="fas fa-lock" style="color:#7c3aed;"></i> Cambiar Contraseña
            </div>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Contraseña actual</label>
                    <input type="password" name="password_actual" required
                        style="width:100%;padding:0.55rem 0.85rem;border:1px solid {{ $errors->has('password_actual') ? '#e11d48' : '#e2e8f0' }};border-radius:8px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    @error('password_actual')<span style="color:#e11d48;font-size:11px;">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Nueva contraseña</label>
                    <input type="password" name="password" required minlength="8"
                        style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                </div>
                <div>
                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" required minlength="8"
                        style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.08)'"
                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                </div>
            </div>
            <div style="margin-top:1.25rem;">
                <button type="submit"
                    style="background:#7c3aed;color:#fff;border:none;padding:0.65rem 1.75rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:0.5rem;"
                    onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                    <i class="fas fa-key"></i> Actualizar contraseña
                </button>
            </div>
        </div>
    </form>
    @endif

    {{-- ═══════════ TAB: LANDING ═══════════ --}}
    @if($tab === 'landing')
    @php
        $landing = \App\Models\LandingMedico::where('medico_id', $medico->id)->first();
        $serviciosLanding = \App\Models\LandingServicio::where('medico_id', $medico->id)->orderBy('orden')->get();
        $galeriaLanding   = \App\Models\LandingGaleria::where('medico_id', $medico->id)->orderBy('orden')->get();
    @endphp

    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;margin-bottom:1.25rem;font-size:12px;color:#166534;display:flex;gap:8px;align-items:center;">
        <i class="fas fa-globe" style="flex-shrink:0;"></i>
        <span>Esta información aparece en tu <strong>página pública</strong>.
            <a href="{{ route('landing') }}" target="_blank" style="color:#166534;font-weight:700;margin-left:4px;">
                Ver landing <i class="fas fa-external-link-alt" style="font-size:10px;"></i>
            </a>
        </span>
    </div>

    <div style="display:flex;flex-direction:column;gap:1.25rem;max-width:1000px;">

        {{-- Hero --}}
        <form method="POST" action="{{ route('medico.configuraciones.landing.hero') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#fce7f3;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-star" style="color:#be185d;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Hero — Sección principal</span>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                        <div>
                            <div style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:0.75rem;">
                                <i class="fas fa-user-md" style="color:#7c3aed;font-size:11px;margin-right:4px;"></i>Foto de la doctora
                            </div>
                            @if($landing && $landing->foto_doctora)
                            <div style="margin-bottom:0.6rem;">
                                <img src="{{ Storage::url($landing->foto_doctora) }}" style="max-height:80px;max-width:160px;border:1px solid #e2e8f0;border-radius:8px;object-fit:cover;">
                            </div>
                            @endif
                            <div x-data="{ preview: null }" style="border:2px dashed #e2e8f0;border-radius:10px;padding:1.25rem;text-align:center;cursor:pointer;transition:all .2s;"
                                 @dragover.prevent="$el.style.borderColor='#7c3aed';$el.style.background='#faf5ff'"
                                 @dragleave="$el.style.borderColor='#e2e8f0';$el.style.background='transparent'"
                                 @drop.prevent="$el.style.borderColor='#e2e8f0';$el.style.background='transparent';let f=$event.dataTransfer.files[0];if(f){let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f);$refs.fotoDoctora.files=$event.dataTransfer.files;}"
                                 @click="$refs.fotoDoctora.click()">
                                <template x-if="!preview"><div><i class="fas fa-cloud-upload-alt" style="font-size:1.5rem;color:#a78bfa;margin-bottom:0.3rem;"></i>
                                <p style="color:#64748b;font-size:0.82rem;margin:0;">Arrastra o <span style="color:#7c3aed;font-weight:600;">selecciona</span></p></div></template>
                                <template x-if="preview"><img :src="preview" style="max-height:80px;max-width:180px;border-radius:8px;object-fit:cover;margin:0 auto;display:block;"></template>
                                <input type="file" name="foto_doctora" accept="image/*" x-ref="fotoDoctora" style="display:none"
                                       @change="let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL($event.target.files[0])">
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:1rem;">
                            <div>
                                <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Título principal</label>
                                <input type="text" name="hero_titulo" value="{{ old('hero_titulo', $landing->hero_titulo ?? 'Realza tu belleza natural.') }}"
                                    style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;"
                                    onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                            </div>
                            <div>
                                <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Descripción</label>
                                <textarea name="hero_descripcion" rows="3" style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;resize:vertical;"
                                    onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">{{ old('hero_descripcion', $landing->hero_descripcion ?? '') }}</textarea>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
                                <div>
                                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Años exp.</label>
                                    <input type="text" name="anos_experiencia" value="{{ old('anos_experiencia', $landing->anos_experiencia ?? '5+') }}"
                                        style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;"
                                        onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                                <div>
                                    <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Nº pacientes</label>
                                    <input type="text" name="num_pacientes" value="{{ old('num_pacientes', $landing->num_pacientes ?? '500+') }}"
                                        style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;"
                                        onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:flex-end;margin-top:1rem;padding-top:1rem;border-top:1px solid #f1f5f9;">
                        <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.6rem 1.5rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:0.5rem;"
                                onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                            <i class="fas fa-save"></i> Guardar hero
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Sobre mí --}}
        <form method="POST" action="{{ route('medico.configuraciones.landing.sobre') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#dbeafe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-user" style="color:#2563eb;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Sobre mí</span>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                        <div>
                            <div style="font-size:0.78rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.5px;margin-bottom:0.75rem;">
                                <i class="fas fa-hospital" style="color:#7c3aed;font-size:11px;margin-right:4px;"></i>Foto consultorio
                            </div>
                            @if($landing && $landing->foto_consultorio)
                            <div style="margin-bottom:0.6rem;">
                                <img src="{{ Storage::url($landing->foto_consultorio) }}" style="max-height:80px;max-width:160px;border:1px solid #e2e8f0;border-radius:8px;object-fit:cover;">
                            </div>
                            @endif
                            <div x-data="{ preview: null }" style="border:2px dashed #e2e8f0;border-radius:10px;padding:1.25rem;text-align:center;cursor:pointer;transition:all .2s;"
                                 @dragover.prevent="$el.style.borderColor='#7c3aed';$el.style.background='#faf5ff'"
                                 @dragleave="$el.style.borderColor='#e2e8f0';$el.style.background='transparent'"
                                 @drop.prevent="$el.style.borderColor='#e2e8f0';$el.style.background='transparent';let f=$event.dataTransfer.files[0];if(f){let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f);$refs.fotoConsultorio.files=$event.dataTransfer.files;}"
                                 @click="$refs.fotoConsultorio.click()">
                                <template x-if="!preview"><div><i class="fas fa-cloud-upload-alt" style="font-size:1.5rem;color:#a78bfa;margin-bottom:0.3rem;"></i>
                                <p style="color:#64748b;font-size:0.82rem;margin:0;">Arrastra o <span style="color:#7c3aed;font-weight:600;">selecciona</span></p></div></template>
                                <template x-if="preview"><img :src="preview" style="max-height:80px;max-width:180px;border-radius:8px;object-fit:cover;margin:0 auto;display:block;"></template>
                                <input type="file" name="foto_consultorio" accept="image/*" x-ref="fotoConsultorio" style="display:none"
                                       @change="let r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL($event.target.files[0])">
                            </div>
                        </div>
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;">Texto sobre mí</label>
                            <textarea name="sobre_mi" rows="7" style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;resize:vertical;"
                                onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">{{ old('sobre_mi', $landing->sobre_mi ?? '') }}</textarea>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:flex-end;margin-top:1rem;padding-top:1rem;border-top:1px solid #f1f5f9;">
                        <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.6rem 1.5rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:0.5rem;"
                                onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                            <i class="fas fa-save"></i> Guardar sobre mí
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Contacto --}}
        <form method="POST" action="{{ route('medico.configuraciones.landing.contacto') }}">
            @csrf @method('PUT')
            <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
                <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#dcfce7;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-address-card" style="color:#16a34a;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Contacto, horario y redes</span>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fas fa-map-marker-alt" style="color:#e11d48;font-size:10px;margin-right:3px;"></i>Dirección</label>
                            <input type="text" name="direccion" value="{{ old('direccion', $landing->direccion ?? '') }}" placeholder="Av. Principal #123, Mazatlán"
                                style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;"
                                onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fas fa-clock" style="color:#7c3aed;font-size:10px;margin-right:3px;"></i>Horario</label>
                            <input type="text" name="horario" value="{{ old('horario', $landing->horario ?? '') }}" placeholder="Lunes a viernes 9:00 – 18:00"
                                style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;"
                                onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fab fa-whatsapp" style="color:#22c55e;font-size:11px;margin-right:3px;"></i>WhatsApp</label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $landing->whatsapp ?? '') }}" placeholder="6692459586"
                                style="width:100%;padding:0.55rem 0.85rem;border:1px solid #e2e8f0;border-radius:8px;font-size:0.875rem;outline:none;"
                                onfocus="this.style.borderColor='#7c3aed'" onblur="this.style.borderColor='#e2e8f0'">
                        </div>
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fab fa-instagram" style="color:#e1306c;font-size:11px;margin-right:3px;"></i>Instagram</label>
                            <div style="display:flex;align-items:center;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                <span style="padding:0.55rem 0.6rem;background:#f8fafc;border-right:1px solid #e2e8f0;font-size:13px;color:#94a3b8;">@</span>
                                <input type="text" name="instagram" value="{{ old('instagram', $landing->instagram ?? '') }}" placeholder="usuario"
                                    style="flex:1;padding:0.55rem 0.75rem;border:none;font-size:0.875rem;outline:none;">
                            </div>
                        </div>
                        <div>
                            <label style="display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.4rem;text-transform:uppercase;letter-spacing:0.4px;"><i class="fab fa-facebook" style="color:#1877f2;font-size:11px;margin-right:3px;"></i>Facebook</label>
                            <div style="display:flex;align-items:center;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;">
                                <span style="padding:0.55rem 0.6rem;background:#f8fafc;border-right:1px solid #e2e8f0;font-size:13px;color:#94a3b8;">@</span>
                                <input type="text" name="facebook" value="{{ old('facebook', $landing->facebook ?? '') }}" placeholder="usuario"
                                    style="flex:1;padding:0.55rem 0.75rem;border:none;font-size:0.875rem;outline:none;">
                            </div>
                        </div>
                    </div>
                    <div style="display:flex;justify-content:flex-end;margin-top:1rem;padding-top:1rem;border-top:1px solid #f1f5f9;">
                        <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.6rem 1.5rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:0.5rem;"
                                onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                            <i class="fas fa-save"></i> Guardar contacto
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Servicios --}}
        <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);">
            <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:28px;height:28px;background:#fef9c3;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-list" style="color:#ca8a04;font-size:12px;"></i>
                    </div>
                    <span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Servicios de la landing</span>
                </div>
                <button onclick="document.getElementById('form-nuevo-servicio').style.display=document.getElementById('form-nuevo-servicio').style.display==='none'?'block':'none'"
                        style="background:#7c3aed;color:#fff;border:none;padding:0.45rem 1rem;border-radius:7px;font-size:0.82rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:5px;">
                    <i class="fas fa-plus"></i> Agregar
                </button>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <div id="form-nuevo-servicio" style="display:none;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:1rem;margin-bottom:1rem;">
                    <form method="POST" action="{{ route('medico.configuraciones.landing.servicio.store') }}">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr 160px auto;gap:0.75rem;align-items:end;">
                            <div>
                                <label style="display:block;font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:0.3rem;text-transform:uppercase;letter-spacing:0.4px;">Nombre</label>
                                <input type="text" name="nombre" required placeholder="Ej. Toxina Botulínica"
                                    style="width:100%;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:7px;font-size:0.85rem;outline:none;">
                            </div>
                            <div>
                                <label style="display:block;font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:0.3rem;text-transform:uppercase;letter-spacing:0.4px;">Descripción</label>
                                <input type="text" name="descripcion" placeholder="Breve descripción"
                                    style="width:100%;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:7px;font-size:0.85rem;outline:none;">
                            </div>
                            <div>
                                <label style="display:block;font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:0.3rem;text-transform:uppercase;letter-spacing:0.4px;">Ícono</label>
                                <select name="icono" style="width:100%;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:7px;font-size:0.82rem;outline:none;background:white;">
                                    <option value="fa-syringe">💉 Botox / Inyección</option>
                                    <option value="fa-tint">💧 Relleno / Ácido</option>
                                    <option value="fa-leaf">🌿 Bioestimulación</option>
                                    <option value="fa-vial">🧪 PRP / Vial</option>
                                    <option value="fa-magic">✨ Hilos / Lifting</option>
                                    <option value="fa-heart">❤️ Valoración</option>
                                    <option value="fa-spa">🧖 Facial / Spa</option>
                                    <option value="fa-user-md">👨‍⚕️ Consulta</option>
                                    <option value="fa-sun">☀️ Láser / Luz</option>
                                    <option value="fa-bolt">⚡ Tecnología</option>
                                    <option value="fa-gem">💎 Premium</option>
                                    <option value="fa-cut">✂️ Capilar / Cabello</option>
                                    <option value="fa-star">⭐ General</option>
                                </select>
                            </div>
                            <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.5rem 1rem;border-radius:7px;font-size:0.85rem;font-weight:600;cursor:pointer;white-space:nowrap;">
                                <i class="fas fa-plus"></i> Agregar
                            </button>
                        </div>
                    </form>
                </div>
                <form method="POST" action="{{ route('medico.configuraciones.landing.servicio.iconos') }}">
                    @csrf
                    @forelse($serviciosLanding as $sv)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#f8fafc;border-radius:8px;border:1px solid #f1f5f9;margin-bottom:6px;">
                        <div style="display:flex;align-items:center;gap:10px;flex:1;overflow:hidden;">
                            <div style="width:32px;height:32px;background:#ede9fe;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas {{ $sv->icono ?? 'fa-star' }}" style="color:#7c3aed;font-size:13px;"></i>
                            </div>
                            <div style="overflow:hidden;">
                                <div style="font-size:13px;font-weight:600;color:#0f172a;">{{ $sv->nombre }}</div>
                                @if($sv->descripcion)<div style="font-size:11px;color:#64748b;margin-top:1px;">{{ Str::limit($sv->descripcion, 60) }}</div>@endif
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;align-items:center;flex-shrink:0;margin-left:12px;">
                            <select name="iconos[{{ $sv->id }}]"
                                style="padding:5px 8px;border:1px solid #e2e8f0;border-radius:6px;font-size:11px;color:#64748b;background:white;cursor:pointer;">
                                <option value="">🎨 Sin cambio</option>
                                <option value="fa-syringe" {{ $sv->icono=='fa-syringe'?'selected':'' }}>💉 Botox</option>
                                <option value="fa-tint" {{ $sv->icono=='fa-tint'?'selected':'' }}>💧 Relleno</option>
                                <option value="fa-leaf" {{ $sv->icono=='fa-leaf'?'selected':'' }}>🌿 Bioestimulación</option>
                                <option value="fa-vial" {{ $sv->icono=='fa-vial'?'selected':'' }}>🧪 PRP</option>
                                <option value="fa-magic" {{ $sv->icono=='fa-magic'?'selected':'' }}>✨ Hilos</option>
                                <option value="fa-heart" {{ $sv->icono=='fa-heart'?'selected':'' }}>❤️ Valoración</option>
                                <option value="fa-spa" {{ $sv->icono=='fa-spa'?'selected':'' }}>🧖 Facial</option>
                                <option value="fa-user-md" {{ $sv->icono=='fa-user-md'?'selected':'' }}>👨‍⚕️ Consulta</option>
                                <option value="fa-sun" {{ $sv->icono=='fa-sun'?'selected':'' }}>☀️ Láser</option>
                                <option value="fa-cut" {{ $sv->icono=='fa-cut'?'selected':'' }}>✂️ Capilar</option>
                                <option value="fa-gem" {{ $sv->icono=='fa-gem'?'selected':'' }}>💎 Premium</option>
                                <option value="fa-star" {{ $sv->icono=='fa-star'?'selected':'' }}>⭐ General</option>
                            </select>
                            <button type="button" onclick="eliminarServicio({{ $sv->id }})"
                                style="background:none;border:none;color:#e11d48;cursor:pointer;font-size:13px;padding:4px 6px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p style="font-size:12px;color:#94a3b8;text-align:center;padding:1rem;">No hay servicios. Agrega el primero.</p>
                    @endforelse
                    @if($serviciosLanding->count() > 0)
                    <div style="display:flex;justify-content:flex-end;margin-top:10px;">
                        <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.55rem 1.25rem;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;"
                            onmouseover="this.style.background='#6d28d9'" onmouseout="this.style.background='#7c3aed'">
                            <i class="fas fa-save"></i> Guardar iconos
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- Galería --}}
        <div style="background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,0.07);overflow:hidden;">
            <div style="padding:1rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:0.6rem;">
                <div style="width:28px;height:28px;background:#ede9fe;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-images" style="color:#7c3aed;font-size:12px;"></i>
                </div>
                <span style="font-size:0.95rem;font-weight:600;color:#0f172a;">Galería de fotos</span>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <form method="POST" action="{{ route('medico.configuraciones.landing.galeria.store') }}" enctype="multipart/form-data" style="margin-bottom:1.25rem;">
                    @csrf
                    <div style="display:flex;gap:0.75rem;align-items:flex-end;">
                        <div style="flex:1;">
                            <label style="display:block;font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:0.3rem;text-transform:uppercase;letter-spacing:0.4px;">Subir foto</label>
                            <input type="file" name="imagen" accept="image/*" required
                                style="width:100%;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:7px;font-size:0.85rem;">
                        </div>
                        <div style="flex:1;">
                            <label style="display:block;font-size:0.75rem;font-weight:600;color:#64748b;margin-bottom:0.3rem;text-transform:uppercase;letter-spacing:0.4px;">Título (opcional)</label>
                            <input type="text" name="titulo" placeholder="Ej. Resultado botox"
                                style="width:100%;padding:0.5rem 0.75rem;border:1px solid #e2e8f0;border-radius:7px;font-size:0.85rem;outline:none;">
                        </div>
                        <button type="submit" style="background:#7c3aed;color:#fff;border:none;padding:0.55rem 1rem;border-radius:7px;font-size:0.85rem;font-weight:600;cursor:pointer;white-space:nowrap;">
                            <i class="fas fa-upload"></i> Subir
                        </button>
                    </div>
                </form>
                @if($galeriaLanding->count() > 0)
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">
                    @foreach($galeriaLanding as $foto)
                    <div style="position:relative;border-radius:8px;overflow:hidden;aspect-ratio:1;background:#f0ebe3;">
                        <img src="{{ Storage::url($foto->imagen) }}" style="width:100%;height:100%;object-fit:cover;">
                        <form method="POST" action="{{ route('medico.configuraciones.landing.galeria.destroy', $foto) }}" style="position:absolute;top:4px;right:4px;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:rgba(0,0,0,0.5);color:white;border:none;width:24px;height:24px;border-radius:50%;cursor:pointer;font-size:10px;">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <p style="font-size:12px;color:#94a3b8;text-align:center;padding:1rem;">No hay fotos en la galería todavía.</p>
                @endif
            </div>
        </div>

    </div>

    {{-- Forms ocultos para eliminar servicios --}}
    @foreach($serviciosLanding as $sv)
    <form id="del-sv-{{ $sv->id }}" method="POST" action="{{ route('medico.configuraciones.landing.servicio.destroy', $sv) }}" style="display:none;">
        @csrf @method('DELETE')
    </form>
    @endforeach

    @endif

</div>

<script>
function eliminarServicio(id) {
    if (confirm('¿Eliminar este servicio?')) {
        document.getElementById('del-sv-' + id).submit();
    }
}
function toggleDia(dia, activo) {
    document.getElementById('inicio-' + dia).disabled = !activo;
    document.getElementById('fin-' + dia).disabled    = !activo;
    document.getElementById('inicio-' + dia).style.opacity = activo ? '1' : '0.4';
    document.getElementById('fin-' + dia).style.opacity    = activo ? '1' : '0.4';
    document.getElementById('label-dia-' + dia).style.color = activo ? '#0f172a' : '#94a3b8';
}
</script>

@endsection