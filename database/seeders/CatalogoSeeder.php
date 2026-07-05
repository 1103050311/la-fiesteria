<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\EstadoCotizacion;
use App\Models\EstadoInventario;
use App\Models\EstadoRenta;
use App\Models\MetodoPago;
use App\Models\TipoEvento;
use App\Models\TipoIncidencia;
use App\Models\TipoMantenimiento;
use App\Models\TipoMovimiento;
use Illuminate\Database\Seeder;

class CatalogoSeeder extends Seeder
{
    /**
     * Poblar todas las tablas catálogo del sistema.
     */
    public function run(): void
    {
        $this->seedTiposEvento();
        $this->seedEstadosInventario();
        $this->seedEstadosCotizacion();
        $this->seedEstadosRenta();
        $this->seedMetodosPago();
        $this->seedTiposIncidencia();
        $this->seedTiposMovimiento();
        $this->seedTiposMantenimiento();

        $this->command->info('✓ Catálogos sembrados correctamente.');
    }

    private function seedTiposEvento(): void
    {
        $tipos = [
            ['nombre' => 'Boda',              'descripcion' => 'Ceremonia matrimonial'],
            ['nombre' => 'Quinceañera',        'descripcion' => 'Festejo de quince años'],
            ['nombre' => 'XV Años',            'descripcion' => 'Fiesta de XV años'],
            ['nombre' => 'Bautizo',            'descripcion' => 'Celebración de bautismo'],
            ['nombre' => 'Primera Comunión',   'descripcion' => 'Celebración de primera comunión'],
            ['nombre' => 'Graduación',         'descripcion' => 'Ceremonia de graduación'],
            ['nombre' => 'Cumpleaños',         'descripcion' => 'Festejo de cumpleaños'],
            ['nombre' => 'Aniversario',        'descripcion' => 'Celebración de aniversario'],
            ['nombre' => 'Corporativo',        'descripcion' => 'Evento empresarial o corporativo'],
            ['nombre' => 'Conferencia',        'descripcion' => 'Evento de conferencias o seminarios'],
            ['nombre' => 'Cena de Gala',       'descripcion' => 'Cena formal o de gala'],
            ['nombre' => 'Otro',               'descripcion' => 'Otro tipo de evento no clasificado'],
        ];

        foreach ($tipos as $tipo) {
            TipoEvento::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }
    }

    private function seedEstadosInventario(): void
    {
        // El orden de inserción corresponde a las constantes del modelo EstadoInventario
        $estados = [
            ['nombre' => 'Disponible',       'descripcion' => 'Unidad disponible en almacén para renta'],
            ['nombre' => 'Rentado',           'descripcion' => 'Unidad actualmente rentada a un cliente'],
            ['nombre' => 'Reservado',         'descripcion' => 'Unidad reservada para una renta futura confirmada'],
            ['nombre' => 'Mantenimiento',     'descripcion' => 'Unidad en proceso de mantenimiento o reparación'],
            ['nombre' => 'Dañado',            'descripcion' => 'Unidad con daños físicos pendientes de reparación'],
            ['nombre' => 'Perdido',           'descripcion' => 'Unidad reportada como perdida'],
            ['nombre' => 'Fuera de servicio', 'descripcion' => 'Unidad dada de baja definitivamente del inventario'],
        ];

        foreach ($estados as $estado) {
            EstadoInventario::firstOrCreate(['nombre' => $estado['nombre']], $estado);
        }
    }

    private function seedEstadosCotizacion(): void
    {
        // El orden corresponde a las constantes del modelo EstadoCotizacion
        $estados = [
            ['nombre' => 'Pendiente',  'descripcion' => 'Cotización creada, pendiente de envío al cliente'],
            ['nombre' => 'Enviada',    'descripcion' => 'Cotización enviada al cliente en espera de respuesta'],
            ['nombre' => 'Aceptada',   'descripcion' => 'Cotización aceptada por el cliente'],
            ['nombre' => 'Rechazada',  'descripcion' => 'Cotización rechazada por el cliente'],
            ['nombre' => 'Expirada',   'descripcion' => 'Cotización vencida por tiempo sin respuesta'],
        ];

        foreach ($estados as $estado) {
            EstadoCotizacion::firstOrCreate(['nombre' => $estado['nombre']], $estado);
        }
    }

    private function seedEstadosRenta(): void
    {
        // El orden corresponde a las constantes del modelo EstadoRenta
        $estados = [
            ['nombre' => 'Cotizada',     'descripcion' => 'Renta generada desde cotización aceptada, pendiente de confirmar'],
            ['nombre' => 'Confirmada',   'descripcion' => 'Renta confirmada, en espera de preparación'],
            ['nombre' => 'Preparación',  'descripcion' => 'Equipo siendo preparado y verificado para entrega'],
            ['nombre' => 'Entregada',    'descripcion' => 'Equipo entregado al cliente en el lugar del evento'],
            ['nombre' => 'Devuelta',     'descripcion' => 'Equipo devuelto y recibido en almacén'],
            ['nombre' => 'Finalizada',   'descripcion' => 'Renta completada, pagada y cerrada'],
            ['nombre' => 'Cancelada',    'descripcion' => 'Renta cancelada antes de su ejecución'],
        ];

        foreach ($estados as $estado) {
            EstadoRenta::firstOrCreate(['nombre' => $estado['nombre']], $estado);
        }
    }

    private function seedMetodosPago(): void
    {
        // El orden corresponde a las constantes del modelo MetodoPago
        $metodos = [
            ['nombre' => 'Transferencia', 'descripcion' => 'Transferencia bancaria electrónica (SPEI)'],
            ['nombre' => 'Efectivo',      'descripcion' => 'Pago en efectivo en las oficinas o en evento'],
            ['nombre' => 'Tarjeta',       'descripcion' => 'Tarjeta de crédito o débito (terminal física o link)'],
            ['nombre' => 'Cheque',        'descripcion' => 'Pago con cheque bancario'],
            ['nombre' => 'Otro',          'descripcion' => 'Otro método de pago no especificado'],
        ];

        foreach ($metodos as $metodo) {
            MetodoPago::firstOrCreate(['nombre' => $metodo['nombre']], $metodo);
        }
    }

    private function seedTiposIncidencia(): void
    {
        // El orden corresponde a las constantes del modelo TipoIncidencia
        $tipos = [
            ['nombre' => 'Daño',    'descripcion' => 'Equipo con daño físico causado durante la renta'],
            ['nombre' => 'Pérdida', 'descripcion' => 'Equipo no devuelto, reportado como perdido'],
            ['nombre' => 'Retraso', 'descripcion' => 'Devolución fuera del plazo acordado'],
            ['nombre' => 'Robo',    'descripcion' => 'Equipo sustraído con dolo'],
            ['nombre' => 'Otro',    'descripcion' => 'Otro tipo de incidencia no clasificada'],
        ];

        foreach ($tipos as $tipo) {
            TipoIncidencia::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }
    }

    private function seedTiposMovimiento(): void
    {
        // El orden corresponde a las constantes del modelo TipoMovimiento
        $tipos = [
            ['nombre' => 'Entrada',       'descripcion' => 'Entrada de equipo al almacén por compra o devolución'],
            ['nombre' => 'Salida',        'descripcion' => 'Salida de equipo del almacén para entrega al cliente'],
            ['nombre' => 'Reserva',       'descripcion' => 'Reserva de equipo para una renta futura confirmada'],
            ['nombre' => 'Devolución',    'descripcion' => 'Devolución de equipo por parte del cliente al almacén'],
            ['nombre' => 'Mantenimiento', 'descripcion' => 'Movimiento de equipo hacia área de mantenimiento'],
            ['nombre' => 'Ajuste',        'descripcion' => 'Ajuste de inventario por auditoría o corrección'],
            ['nombre' => 'Baja',          'descripcion' => 'Baja definitiva del equipo del inventario activo'],
        ];

        foreach ($tipos as $tipo) {
            TipoMovimiento::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }
    }

    private function seedTiposMantenimiento(): void
    {
        // El orden corresponde a las constantes del modelo TipoMantenimiento
        $tipos = [
            ['nombre' => 'Preventivo',  'descripcion' => 'Mantenimiento preventivo según calendario programado'],
            ['nombre' => 'Correctivo',  'descripcion' => 'Mantenimiento correctivo por falla o daño detectado'],
            ['nombre' => 'Limpieza',    'descripcion' => 'Limpieza y desinfección del equipo post-evento'],
            ['nombre' => 'Calibración', 'descripcion' => 'Calibración o ajuste técnico de precisión'],
            ['nombre' => 'Inspección',  'descripcion' => 'Inspección general del estado del equipo'],
        ];

        foreach ($tipos as $tipo) {
            TipoMantenimiento::firstOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }
    }
}
