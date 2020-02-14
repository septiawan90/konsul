<?php

namespace App\Rules\Nik;

use Illuminate\Contracts\Validation\Rule;

class Gender implements Rule
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
        #3 Gender (maksimal tgl lahir 31, dan 40 pembeda gender P/L)
        $gender = substr($value, 6, 2);
        
        return intval($gender) <= 71;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIK tidak valid. [#03]';
    }
}
