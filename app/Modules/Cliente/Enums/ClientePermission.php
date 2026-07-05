<?php

declare(strict_types=1);

namespace App\Modules\Cliente\Enums;

/**
 * Permisos del módulo Cliente.
 * Se usan en Policies y al sembrar permisos en Spatie.
 */
enum ClientePermission: string
{
    case VIEW_ANY = 'clientes.viewAny';
    case VIEW     = 'clientes.view';
    case CREATE   = 'clientes.create';
    case UPDATE   = 'clientes.update';
    case DELETE   = 'clientes.delete';
    case RESTORE  = 'clientes.restore';

    /**
     * Retorna todos los valores como array de strings (para Seeder de Spatie).
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
