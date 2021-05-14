<?php

namespace App\Models\Etim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EtimModellingClass extends Model
{
    use HasFactory;

    
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public function productClasses() {
        return $this->belongsToMany('App\Models\Etim\EtimProductClasses', 'etim_modelling_class_etim_product_class', 'mc_id', 'ec_id');
    }

    public function translations()
    {
        return $this->morphMany('App\Models\Etim\EtimTranslation', 'translatable');
    }

    public function updateDefinitions($date)
    {

        //register a new update
        $update = new EtimUpdate;

         // Retrieving the modelling classes
        $modelling_classes = $update->findElements("ModellingClasses", $date);
         
       // Process the modelling classes
        foreach ($modelling_classes->children() as $modelling_class) {
            Log::channel('activity')->info('UpdateEtimModellingClass : ' . $modelling_class->Code->__toString());
            // store the modelling classes
            $etimModellingClass = EtimModellingClass::updateOrCreate(
                [
                    'id' => $modelling_class->Code->__toString(),
                    'version' => $modelling_class->Version->__toString(),
                ],
                [
                    'change_code' => $modelling_class->attributes()["changeCode"],
                    'status' => $modelling_class->Status->__toString(),
                    'pdf' => $modelling_class->DimensionalDrawings->DimensionalDrawing->Url->__toString()
                ]
            );

            //retrieving translations for each language within each Modelling class
            // consisting of a description and a set of synonyms
            foreach ($modelling_class->Translations->children() as $translation) {                
                
            //store the translations into the translations table
                $etimTranslation = EtimTranslation::updateOrCreate(
                    [
                        'translatable_type' => 'App\Models\Etim\EtimModellingClass',
                        'translatable_id' => $modelling_class->Code->__toString(),
                        'language' => $translation->attributes()["language"],
                        'translation' => $translation->Description->__toString()
                    ],
                    [

                    ]
                );
                unset($etimTranslation);
                // store the synonyms of this class in a synonyms table
                if ($translation->count() == 1) {continue;}
                foreach ($translation->Synonyms->children() as $synonym) {
                    $etimSynonym = EtimSynonym::updateOrCreate(
                        [
                            'id' => $modelling_class->Code->__toString(),
                            'language' => $translation->attributes()["language"],
                            'synonym' => json_encode($synonym->__toString(), JSON_UNESCAPED_UNICODE)
                        ],
                        [

                        ]);
                    unset($etimSynonym);
                }

            }
            

            if(!$modelling_class->Features) {continue;}
        
            foreach ($modelling_class->Features->children() as $feature) {

                $etimModellingClassEtimFeature = EtimModellingClassEtimFeature::updateOrCreate(
                    [
                        'mc_id' => $modelling_class->Code->__toString(),
                        'ef_id' => $feature->FeatureCode->__toString(),
                    ],
                    [
                        'change_code' => $feature->attributes()["changeCode"],
                        'sort_order' => $feature->OrderNumber->__toString(),
                        'eu_id_metric' => $feature->UnitCode->__toString(),
                        'drawing_code' => $feature->DimensionalDrawingCode->__toString(),
                        'port_code' => $feature->PortCode->__toString(),
                        // 'eu_id_imperial' => $feature->UnitCode->__toString(),

                    ]
                );
                unset($etimModellingClassEtimFeature);

                if(!$feature->Values) {continue;}
                foreach ($feature->Values->children() as $value) {
                    $etimModellingClassEtimFeatureEtimValue = EtimModellingClassEtimFeatureEtimValue::updateOrCreate(
                        [
                            'mc_id' => $modelling_class->Code->__toString(),
                            'ef_id' => $feature->FeatureCode->__toString(),
                            'ev_id' => $value->ValueCode->__toString()

                        ],
                        [
                            'sort_order' => $value->OrderNumber->__toString()

                        ]
                    );
                    unset($etimModellingClassEtimFeatureEtimValue);
                }
            }
        }
    }   
}
