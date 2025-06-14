<?php

namespace App\Http\Controllers;

use App\Utils\Trait\DataSanitizer;

abstract class Controller
{
    use DataSanitizer;
}
