<?php

namespace App\Config;

use App\Entity\User;

class OperationConfig
{
    public static function getCollectionOperations(): array {
        return [
            "get"  => ["method" => "GET"],
            "post" => ["method" => "POST", "security" => "is_granted('" . User::ROLE_ADMIN . "')"]
        ];
    }

    public static function getItemOperations(): array {
        return [
            "get"    => ["method" => "GET"],
            "put"    => ["method" => "PUT", "security" => "is_granted('" . User::ROLE_ADMIN . "')"],
            "delete" => ["method" => "DELETE", "security" => "is_granted('" . User::ROLE_ADMIN . "')"],
            "patch"  => ["method" => "PATCH", "security" => "is_granted('" . User::ROLE_ADMIN . "')"]
        ];
    }
}