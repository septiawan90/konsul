<?php

namespace App\Rules\Nik;

use Illuminate\Contracts\Validation\Rule;

class Tgl implements Rule
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
        $tgl        = substr($value, 6, 2);
        $max_tgl    = $tgl - 40;
        return $max_tgl <= 31;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIK tidak valid. [#04]';
    }
}
