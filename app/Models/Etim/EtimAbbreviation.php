<?php

namespace App\Models\Etim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtimAbbreviation extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected $keyType = 'string';
    public $incrementing = false;

    public function unit() 
    {
        return $this->belongsTo('App\Models\ETIM\EtimUnit');
    }

    // public function translations()
    // {
    //     return $this->morphMany('App\Models\ETIM\EtimTranslation', 'translatable');
    // }

}
