<?php

namespace App\Service\Security;

class PasswordGenerator
{
    private const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';

    public static function generate(int $length = 32): string
    {
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= self::CHARACTERS[random_int(0, strlen(self::CHARACTERS) - 1)];
        }

        return $password;
    }
}