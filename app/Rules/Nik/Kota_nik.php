<?php

namespace App\Rules\Nik;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Daerah\Kota;

class Kota_nik implements Rule
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
		#2 cek kota
		$kota 	    = substr($value, 0, 4);
        $kota_id 	= Kota::find($kota);		
        
        return $kota_id != null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIK tidak valid. [#02]';
    }
}
