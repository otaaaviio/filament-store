<?php

namespace App\Enums;

use App\Support\Traits\EnumHelpers;

enum OrderStatusEnum: int
{
    use EnumHelpers;

    case PENDING = 1;
    case PROCESSING = 2;
    case PAID = 3;
    case SHIPPED = 4;
    case DELIVERED = 5;
    case CANCELLED = 6;

    public static function getLabels(): array
    {
        return [
            self::PENDING->value => 'Pendente',
            self::PROCESSING->value => 'Processando',
            self::PAID->value => 'Pago',
            self::SHIPPED->value => 'Enviado',
            self::DELIVERED->value => 'Entregue',
            self::CANCELLED->value => 'Cancelado',
        ];
    }
}
