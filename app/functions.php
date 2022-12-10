<?php

use App\Models\Pengaturan;

if(!function_exists('getSettings')) {
  function getSettings($key, $return = 'value')
  {
    $data = Pengaturan::where('Kode',$key)->first();
    return ($return == 'all') ? $data : $data->Isi;
  }
}