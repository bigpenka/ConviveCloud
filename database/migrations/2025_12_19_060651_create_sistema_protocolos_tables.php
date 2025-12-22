<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. PROTOCOLOS (Expediente)
        Schema::create('protocolos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // vulneracion, sexual
            $table->string('estado')->default('Abierto'); 
            $table->foreignId('user_id')->constrained(); // Encargado
            
            // Fechas de Control
            $table->dateTime('fecha_activacion')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->text('observacion_cierre')->nullable();
            
            // Banderas de Avance (Checklist)
            $table->boolean('entrevista_realizada')->default(false);
            $table->boolean('denuncia_fiscalia')->default(false);
            $table->boolean('denuncia_tribunal')->default(false);
            
            $table->timestamps();
        });

        // 2. INVOLUCRADOS (Adaptado de tu formulario antiguo)
        Schema::create('involucrados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('protocolo_id')->constrained()->onDelete('cascade');
            
            // Datos Personales
            $table->string('rut')->nullable();
            $table->string('nombres');
            $table->string('paterno');
            $table->string('materno')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('genero')->nullable();
            $table->string('nacionalidad')->default('CHILENO');
            
            // Datos Escolares / Rol
            $table->string('rol'); // AFECTADO, AGRESOR, TESTIGO
            $table->string('calidad'); // ESTUDIANTE, DOCENTE, ASISTENTE
            $table->string('curso')->nullable();
            $table->string('letra')->nullable();
            $table->boolean('miembro_ece')->default(false);
            
            // Contacto
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('comuna')->nullable();
            
            // Apoderado Titular
            $table->string('nombre_apoderado')->nullable();
            $table->string('telefono_apoderado')->nullable();
            $table->string('email_apoderado')->nullable();
            $table->string('vinculo_apoderado')->nullable(); // PADRE, MADRE, TUTOR
            $table->string('direccion_apoderado')->nullable();

            // Apoderado Suplente (Como en tu formulario original)
            $table->string('nombre_apoderado2')->nullable();
            $table->string('telefono_apoderado2')->nullable();
            $table->timestamps();
        });

        // 3. HECHOS (Bitácora detallada)
        Schema::create('hechos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('protocolo_id')->constrained()->onDelete('cascade');
            
            // Tiempos
            $table->date('fecha_inicio');
            $table->time('hora_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->time('hora_fin')->nullable();
            
            // Detalle
            $table->text('relato');
            $table->boolean('es_delito')->default(false);
            $table->string('documento_adjunto')->nullable(); // URL S3 o Local
            
            // Informante (Quien comunica el hecho)
            $table->string('informante_nombre')->nullable();
            $table->string('informante_relacion')->nullable(); // Cargo o Función
            $table->string('informante_contacto')->nullable(); // Email/Teléfono
            
            $table->timestamps();
        });
        
        // 4. NOTIFICACIONES (Fiscalía, Tribunal)
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('protocolo_id')->constrained()->onDelete('cascade');
            $table->string('tipo'); // 'FISCALIA', 'TRIBUNAL', 'ACTIVACION'
            $table->string('institucion_destino')->nullable(); // Ej: 'Fiscalía Local Temuco'
            $table->dateTime('fecha_envio')->useCurrent();
            $table->string('documento_adjunto')->nullable(); // Certificado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones');
        Schema::dropIfExists('hechos');
        Schema::dropIfExists('involucrados');
        Schema::dropIfExists('protocolos');
    }
};