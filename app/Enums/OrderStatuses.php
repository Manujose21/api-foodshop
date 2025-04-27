<?php

namespace App\Enums;        

class OrderStatuses {

    const PENDING = 'pending';
    const COMPLETED = 'completed';
    CONST CANCELLED = 'cancelled';

    public static function getValues() {
        return [
            self::PENDING,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }

}
