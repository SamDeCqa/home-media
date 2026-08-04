<?php

namespace App\Enums;

enum RolesEnum : string
{
    case ADMIN = 'admin';
    case GUEST = 'guest';
    case MEMBER = 'member';

    public function getLabel(){
        return match ($this) {
            self::ADMIN => 'Admin',
            self::GUEST => 'Guest',
            self::MEMBER => 'Member'
        };
    }
}
