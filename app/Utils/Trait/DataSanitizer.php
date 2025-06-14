<?php

namespace App\Utils\Trait;

trait DataSanitizer
{
    protected function sanitize($data): string
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return stripslashes($data);
    }
}
