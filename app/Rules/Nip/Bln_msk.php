<?php

namespace App\Rules\Nip;

use Illuminate\Contracts\Validation\Rule;

class Bln_msk implements Rule
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
		#5 cek bulan masuk 
        $bln 	    = substr($value, 12, 2);
        return intval($bln) <= 12;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIP tidak valid. [#05]';
    }
}
