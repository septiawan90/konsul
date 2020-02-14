<?php

namespace App\Rules\Nik;

use Illuminate\Contracts\Validation\Rule;

class Bln implements Rule
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
        $bln = substr($value, 8, 2);
        return intval($bln) <= 12;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIK tidak valid. [#05]';
    }
}
