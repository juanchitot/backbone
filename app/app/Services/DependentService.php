<?php

namespace App\Services;

class DependentService
{

    public function depDemo(): string
    {
        return self::class;
    }
}
