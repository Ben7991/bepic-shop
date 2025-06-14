<?php

declare(strict_types=1);

namespace App\Utils;

final class TextGenerator
{
    /**
     * Create a new class instance.
     */
    private function __construct() {}

    public static function generate(int $length = 12)
    {
        $generateLetters = "";
        $characters = "abcdefghijklmnopqrstuvwxyz0123456789";
        $upperBound = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, $upperBound);
            $generateLetters .= $characters[$index];
        }

        return $generateLetters;
    }
}
