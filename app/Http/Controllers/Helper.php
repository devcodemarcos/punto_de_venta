<?php

namespace App\Http\Controllers;

use App\Models\Product;

class Helper
{
    public $i = 100;
    static function translate_error_db($text): string
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

    static function generateUUID($length = 10)
    {
        $barcode = '';

        do {
            for ($i = 0; $i < $length; $i++) {
                $barcode .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('0'), ord('9')));
            }

            $products = Product::where('barcode', $barcode)->get();
        } while ($products->count() > 0);

        return $barcode;
    }
}
