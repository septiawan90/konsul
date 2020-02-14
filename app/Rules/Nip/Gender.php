<?php

namespace App\Rules\Nip;

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
		#6 cek gender
		$gender 	    = substr($value, 14, 1); 
        return intval($gender) <= 2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIP tidak valid. [#06]';
    }
}
