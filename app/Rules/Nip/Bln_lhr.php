<?php

namespace App\Rules\Nip;

use Illuminate\Contracts\Validation\Rule;

class Bln_lhr implements Rule
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
		#2 cek bulan lahir
        $bln 	    = substr($value, 4, 2);
        return intval($bln) <= 12;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIP tidak valid. [#02]';
    }

    // function validateDate($date, $format = 'Y-m-d H:i:s')
    // {
    //     $d = DateTime::createFromFormat($format, $date);
    //     return $d && $d->format($format) == $date;
    // }
}
