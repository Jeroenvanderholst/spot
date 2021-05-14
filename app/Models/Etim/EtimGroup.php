<?php

namespace App\Models\Etim;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtimGroup extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    public function productClasses() {
        return $this->hasMany('App\Models\ETIM\EtimProductClass', 'eg-id', 'id');
    }

    public function translations()
    {
        return $this->morphMany('App\Models\ETIM\EtimTranslation', 'translatable');
    }

    public function updateDefinitions($date)
    {

        $update = new EtimUpdate;
        $groups = $update->findElements("Groups", $date);
        $totalcount = $groups->count();
        $count = 0;

        foreach ($groups->children() as $group) {
            $group->registerXPathNamespace('ns', config('etim.namespace'));
            $etimGroup = EtimGroup::updateOrCreate(
                [
                    'id' => $group->Code->__toString(),
                ],
                [
                    'description' => $group->xpath('ns:Translations/ns:Translation[@language="EN"]/ns:Description')[0]->__toString()
                ]
            );


            foreach ($group->Translations->children() as $translation) {

                $etimTranslation = EtimTranslation::updateOrCreate(
                    [
                        'translatable_type' => 'App\Models\ETIM\EtimGroup',
                        'translatable_id' => $group->Code->__toString(),
                        'language' => $translation->attributes()["language"]
                    ],
                    [
                        'translation' => $translation->Description->__toString()
                    ]
                );
                unset($etimTranslation);
            }
            unset($etimGroup);
        }
    }   
}
