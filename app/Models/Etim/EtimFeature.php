<?php

namespace App\Models\Etim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtimFeature extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public function productClasses () {
        return $this->belongsToMany('App\Models\ETIM\EtimProductClass','product_class_features', 'ec_id', 'ef_id');
    }

    public function translations()
    {
        return $this->morphMany('App\Models\ETIM\EtimTranslation', 'translatable');
    }
    
    public function updateDefinitions($date)
    {

        $update = new EtimUpdate;
        $features = $update->findElements("Features", $date);
        // $totalcount = $features->count();
        // $count = 0;

        foreach ($features->children() as $feature) {
            $feature->registerXPathNamespace('ns', config('etim.namespace'));
            $etimFeature = EtimFeature::updateOrCreate(
                [
                    'id' => $feature->Code->__toString(),
                ],
                [
                    'type' => $feature->Type->__toString(),
                    'description' => $feature->xpath('ns:Translations/ns:Translation[@language="EN"]/ns:Description')[0]->__toString(), 
                ]
            );


            foreach ($feature->Translations->children() as $translation) {

                $etimTranslation = EtimTranslation::updateOrCreate(
                    [
                        'translatable_type' => 'App\Models\ETIM\EtimFeature',
                        'translatable_id' => $feature->Code->__toString(),
                        'language' => $translation->attributes()["language"]
                    ],
                    [
                        'translation' => $translation->Description->__toString()
                    ]
                );
                unset($etimTranslation);
            }
            unset($etimFeature);
        }
    }    
}
