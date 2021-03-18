<?php

namespace App\Http\Controllers;

class Helper
{
    static function translate_error_db($text) : string
    {
        $text = str_replace("'", "", $text);
        $index = explode(" ", $text);
        $array = [
            'providers_phone_unique' => 'teléfono',
            'providers_email_unique' => 'correo electrónico',
            'products_barcode_unique' => 'código de barras'
        ];

        return $array[$index[5]];
    }
}
