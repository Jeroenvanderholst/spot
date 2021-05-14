<?php

namespace App\Models\Etim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EtimProductClass extends Model
{
    use HasFactory;

    protected $fillable = ['id' , 'version', 'change_code', 'description', 'status', 'eg_id'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function features()
     {
        return $this->belongsToMany('App\Models\Etim\EtimFeatures', 'product_class_features', 'ef_id', 'ec_id');
    }

    public function group() 
    {
        return $this->belongsTo('App\Models\Etim\EtimGroup', 'eg_id' );
    }

    public function modellingClasses() 
    {
        return $this->belongsToMany('App\Models\Etim\EtimModellingClasses', 'etim_modelling_class_links', 'ec_id', 'mc_id');
    }
    public function translations()
    {
        return $this->morphMany('App\Models\Etim\EtimTranslation', 'translatable');
    }
    public function updateDefinitions($date)
    {

        //register a new update
        $update = new EtimUpdate;
        // find the product classes
        $product_classes = $update->findElements("Classes", $date);
 
        //process the productclasses
        foreach ($product_classes->children() as $product_class) {
            Log::channel('activity')->info('processing: ' . $product_class->Code->__toString());

            $etimProductClass = EtimProductClass::updateOrCreate(
                [
                    'id' => $product_class->Code->__toString(),
                    'version' => $product_class->Version->__toString()

                ],
                [
                    'change_code' => $product_class->attributes()["changeCode"],
                    'status' => $product_class->Status->__toString(),
                    'eg_id' => $product_class->GroupCode->__toString(),
                ]);
            unset($etimProductClass);
        
            //retrieving translations for each language within each product class
            // consisting of a description and a set of synonyms
            foreach ($product_class->Translations->children() as $translation) {
               
                $etimTranslation = EtimTranslation::updateOrCreate(
                    [
                        
                        'translatable_id' => $product_class->Code->__toString(),
                        'language' =>$translation->attributes()["language"],
                        
                    ],
                    [
                        'translatable_type' => 'App\Models\Etim\EtimProductClass',
                        'translation' => $translation->Description->__toString(),
                    ]
                );

                unset($etimTranslation);

                //if there are synonyms, store them in the synonyms table
                if ($translation->count() < 2) {continue;}
                foreach ($translation->Synonyms->children() as $synonym) {
                    $etimSynonym = EtimSynonym::updateOrCreate(
                        [
                            'id' => $product_class->Code->__toString(),
                            'language' => $translation->attributes()["language"],
                            'synonym' => $synonym->__toString()
                        ],
                        [

                        ]
                    );
                    
                }
                // Log::channel('activity')->info('UpdateEtimProductClasses - ' . $etimProductClass);

                unset($etimSynonym);

            }
            if (!$product_class->Features){continue;}


            foreach ($product_class->Features->children() as $feature) {

                $etimProductClassEtimFeatures = EtimProductClassEtimFeature::updateOrCreate(
                    [
                        'ec_id' => $product_class->Code->__toString(),
                        'ef_id' => $feature->FeatureCode->__toString(),
                    ],
                    [
                        'change_code' => $feature->attributes()["changeCode"],
                        'sort_order' => $feature->OrderNumber->__toString(),
                        'eu_id_metric' => $feature->UnitCode->__toString(),
                        // 'eu_id_imperial' => $feature->UnitCode->__toString(),

                    ]
                );
                if (!$feature->Values){continue;}
                foreach ($feature->Values->children() as $value) {
                    $etimProductClassEtimFeatureEtimValue = EtimProductClassEtimFeatureEtimValue::updateOrCreate(
                        [
                            'ec_id' => $product_class->Code->__toString(),
                            'ef_id' => $feature->FeatureCode->__toString(),
                            'ev_id' => $value->ValueCode->__toString()

                        ],
                        [
                            'sort_order' => $value->OrderNumber->__toString()


                        ]
                    );
                    unset($etimProductClassEtimFeatureEtimValue);
                }
                unset($etimProductClassEtimFeatures);

                if(!$product_class->ModellingClasses) {continue;}

                foreach ($product_class->ModellingClasses->ModellingClass as $modelling_class) {
                    $etimModellingClassEtimProductClass = EtimModellingClassEtimProductClass::updateOrCreate(
                        [
                            'ec_id' => $product_class->Code->__toString(),
                            'mc_id' => $modelling_class->Code->__toString(),
                        ],
                        [
                            'version' => $modelling_class->Version->__toString(),
                        ]
                        );
                }
                unset($etimModellingClassEtimProductClass);
            }
        }
    }
}
