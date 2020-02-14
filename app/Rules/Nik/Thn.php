<?php

namespace App\Rules\Nik;

use Illuminate\Contracts\Validation\Rule;

class Thn implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        #6 cek tahun (minimal tahun kelahiran 1930 atau maks > 80 tahun)
        $thn 	= substr($value, 10, 2);
        return intval($thn) >= 30;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIK tidak valid. [#06]';
    }
}
