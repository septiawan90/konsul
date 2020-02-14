<?php

namespace App\Rules\Nip;

use Illuminate\Contracts\Validation\Rule;

class Thn_lhr implements Rule
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
        #1 cek tahun lahir (minimal tahun kelahiran 1930 atau maks > 80 tahun)
        $thn 	= substr($value, 0, 4);
        return intval($thn) >= 1930;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIP tidak valid. [#01]';
    }
}
