<?php

namespace App\Database;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $timestamps = false;

    public static function get($column = array('*')){
    	foreach (self::select($column)->get() as $key => $value) {
    		$value;
    	}
    	return $value;
    }
}
