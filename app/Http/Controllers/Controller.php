<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function sanitize($data): string {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return stripslashes($data);
    }
}
