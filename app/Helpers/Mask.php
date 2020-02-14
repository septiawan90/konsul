<?php
	
	use App\Models\Daerah\Provinsi;
	use App\Models\Daerah\Kota;
	use App\Models\Daerah\Kecamatan;

	// masking
	function maskEmail($email)
    {
       	$mail_segments = explode("@", $email);
		$mail_segments[0] = str_repeat("*", strlen($mail_segments[0]));

		return implode("@", $mail_segments);
    }
	
	function maskText($text)
	{
		return substr($text, 0, -5)."*****";
	}

	function kapital($text)
	{
		return ucwords(strtolower($text));
	}

	// tanggal
	function tanggal($date)
	{
		return date("d-m-Y", strtotime($date));
	}

	function lastUpdate($date)
	{
		return date("d.m.y", strtotime($date)).', '.date("H:i:s", strtotime($date));
	}

	function hari($date)
	{
		$hari = date("D", strtotime($date));

		switch($hari){
			case 'Sun':
				$hari = "Minggu";
			break;

			case 'Mon':			
				$hari = "Senin";
			break;

			case 'Tue':
				$hari = "Selasa";
			break;

			case 'Wed':
				$hari = "Rabu";
			break;

			case 'Thu':
				$hari = "Kamis";
			break;

			case 'Fri':
				$hari = "Jumat";
			break;

			case 'Sat':
				$hari = "Sabtu";
			break;
			
			default:
				$hari = "Tidak di ketahui";		
			break;
		}

		return $hari.', '.date('d-m-Y', strtotime($date));
	}

	// NIK
	function cekNik($nik)
	{
		// 1. Cek Provinsi
		// 2. Cek Kota
		// 3. Cek Gender
		// 4. Cek Tanggal Lahir
		// 5. Cek Bulan Lahir
		// 6. Cek Tahun Lahir
		
		#1 cek provinsi
		$provinsi 	= substr($nik, 0, 2);
		$prov_id 	= Provinsi::find($provinsi);		

		if(is_null($prov_id))
		{
			return 'Format NIK tidak valid. [#01]';
		}
		else
		{
			#2 cek kota
			$kota 			= $prov_id.substr($nik, 2, 2);
			$kota_id 		= Kota::find($kota);
			
			if(is_null($kota_id))
			{
				var_dump($kota); die;
				return back()->with('error', 'Format NIK tidak valid. [#02]');
			}
			else
			{
				#3 Gender (maksimal tgl lahir 31, dan 40 pembeda gender P/L)
				$tgl = substr($nik, 6, 2);

				if(intval($tgl) > 71)
				{
					var_dump('03'); die;
					return back()->with('error', 'Format NIK tidak valid. [#03]');
				}
				else
				{
					#4 Tanggal Lahir (maksimal tanggal 31)
					$max_tgl = $tgl-40;
					
					if($max_tgl > 31) 
					{
						var_dump('04'); die;
						return back()->with('error', 'Format NIK tidak valid. [#04]');
					}
					else
					{
						#5 cek bulan (maksimal bulan 12)
						$bln 	= substr($nik, 8, 2);
						if($bln > 12)
						{
							var_dump('05'); die;
							return back()->with('error', 'Format NIK tidak valid. [#05]');
						}
						else 
						{
							#6 cek tahun (minimal tahun kelahiran 1930 atau maks > 80 tahun)
							$thn 	= substr($nik, 10, 2);
							if($thn < 31)
							{
								var_dump('06'); die;
								return back()->with('error', 'Format NIK tidak valid. [#06]');
							}
							else
							{
								return TRUE;
							}
						}
					}
				}
			}
		}
	}

	function nikGender($nik)
	{
		$gender = substr($nik, 6, 2);

		if (intval($gender) > 40) 
		{
			return 'Wanita';
		} 
		else 
		{
			return 'Pria';
		}
	}

	function nikLahir($nik)
    {
		$tgl 	= substr($nik, 6, 2);
		$bln 	= substr($nik, 8, 2);
		$thn 	= substr($nik, 10, 2);

		if($tgl > 40) 
		{
			$tgl = $tgl - 40;
			return $tgl.'-'.$bln.'-'.$thn;
		} 
		else 
		{
			return $tgl.'-'.$bln.'-'.$thn;
		}
	}

	function nikDaerah($nik)
    {
		$provinsi 		= substr($nik, 0, 2);
		$kota 			= substr($nik, 2, 2);
		$kecamatan 		= substr($nik, 4, 2);

		return kode_provinsi($provinsi);
	}

	function kode_provinsi($i) 
	{
		$i = intval($i);
		$data = array(
			11 => 'Aceh',
			12 => 'Sumatera Utara',
			13 => 'Sumatera Barat',
			14 => 'Riau',
			15 => 'Jambi',
			16 => 'Sumatera Selatan',
			17 => 'Bengkulu',
			18 => 'Lampung',
			19 => 'Kep. Bangka Belitung',
			21 => 'Kep. Riau',
			31 => 'DKI Jakarta',
			32 => 'Jawa Barat',
			33 => 'Jawa Tengah',
			34 => 'Yogyakarta',
			35 => 'Jawa Timur',
			36 => 'Banten',
			51 => 'Bali',
			52 => 'Nusa Tenggara Barat',
			53 => 'Nusa Tenggara Timur',
			61 => 'Kalimantan Barat',
			62 => 'Kalimantan Tengah',
			63 => 'Kalimantan Selatan',
			64 => 'Kalimantan Timur',
			71 => 'Sulawesi Utara',
			72 => 'Sulawesi Tengah',
			73 => 'Sulawesi Selatan',
			74 => 'Sulawesi Tenggara',
			75 => 'Gorontalo',
			76 => 'Sulawesi Barat',
			81 => 'Maluku',
			82 => 'Maluku Utara',
			91 => 'Papua Barat',
			94 => 'Papua'
		);

		if(isset($data[$i])) 
		{
			return trim($data[$i]);
		}

		return '<span class="error">Invalid</span>';
	}
