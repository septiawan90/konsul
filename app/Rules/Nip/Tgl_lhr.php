<?php

namespace App\Rules\Nip;

use Illuminate\Contracts\Validation\Rule;

class Tgl_lhr implements Rule
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
		#3 cek tanggal lahir
		$tgl 	    = substr($value, 4, 2);
        return intval($tgl) <= 31;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIP tidak valid. [#03]';
    }
}
