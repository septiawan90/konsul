<?php

namespace App\Rules\Nik;

use Illuminate\Contracts\Validation\Rule;

use App\Models\Daerah\Provinsi;

class Prov implements Rule
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
        // 1. Cek Provinsi
		// 2. Cek Kota
		// 3. Cek Gender
		// 4. Cek Tanggal Lahir
		// 5. Cek Bulan Lahir
		// 6. Cek Tahun Lahir
		
		#1 cek provinsi
		$provinsi 	= substr($value, 0, 2);
        $prov_id 	= Provinsi::find($provinsi);		
        
        return $prov_id != null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Format NIK tidak valid. [#01]';
    }
}
