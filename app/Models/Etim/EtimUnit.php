<?php

namespace App\Models\Etim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtimUnit extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;



    // dit kan waarschijnlijk weg

    // public function updateDefinitions($date)
    // {
        
    //     // DB::table('etim_units')->delete();
    //     $update = new EtimUpdate;
    //     $units = $update->findElements("Units", $date);
        
    //     foreach ($units->children() as $unit) {

    //         $unit->registerXPathNamespace('ns', config('etim.namespace'));
    //         foreach ($unit->Translations->children() as $translation) {
    //             // dd($unit->Code->__toString());
    //             // dd($unit->xpath('ns:Translations/ns:Translation[@language="EN"]/ns:Description')[0]->__toString());
    //             $etimUnit = EtimUnit::updateOrCreate(
    //                 [
    //                     'id' => $unit->Code->__toString(),
    //                     'language' => $translation->attributes()->{'language'}->__toString(),
    //                 ],
    //                 [
    //                     'abbreviation' => $translation->Abbreviation->__toString(),
    //                     'description' => $translation->Description->__toString(),

    //                 ]
    //             );
    //         }
            

            
    //     }
    // }
}
