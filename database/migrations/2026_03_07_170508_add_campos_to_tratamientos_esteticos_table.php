use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->string('grupo', 1)->nullable();
            $table->string('tipo_clave', 30)->nullable();
            $table->string('motivo_consulta')->nullable();
            $table->tinyInteger('fitzpatrick')->nullable();
            $table->json('tipo_piel')->nullable();
            $table->json('condiciones_piel')->nullable();
            $table->json('antecedentes')->nullable();
            $table->string('simetria')->nullable();
            $table->string('tonicidad')->nullable();
            $table->string('tecnica')->nullable();
            $table->string('profundidad')->nullable();
            $table->string('producto_marca')->nullable();
            $table->string('producto_lote')->nullable();
            $table->date('producto_caducidad')->nullable();
            $table->integer('sesion_numero')->default(1);
            $table->string('intervalo')->nullable();
            $table->decimal('volumen_total', 6, 2)->nullable();
            $table->string('unidad_volumen', 10)->nullable();
            $table->text('objetivo')->nullable();
            $table->text('observaciones_post')->nullable();
            $table->string('consentimiento_idioma', 10)->default('es');
            $table->string('consentimiento_entrega', 20)->nullable();
            $table->json('campos_extra')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('tratamientos_esteticos', function (Blueprint $table) {
            $table->dropColumn([
                'grupo','tipo_clave','motivo_consulta',
                'fitzpatrick','tipo_piel','condiciones_piel','antecedentes',
                'simetria','tonicidad','tecnica','profundidad',
                'producto_marca','producto_lote','producto_caducidad',
                'sesion_numero','intervalo','volumen_total','unidad_volumen',
                'objetivo','observaciones_post',
                'consentimiento_idioma','consentimiento_entrega','campos_extra',
            ]);
        });
    }
};
