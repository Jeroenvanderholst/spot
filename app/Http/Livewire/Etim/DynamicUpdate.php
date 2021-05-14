<?php

namespace App\Http\Livewire\Etim;

use App\Jobs\DownloadEtimIXF;
use App\Jobs\UpdateEtimUnits;
use App\Jobs\UpdateEtimValues;
use App\Jobs\UpdateEtimGroups;
use App\Jobs\UpdateEtimFeatures;
use App\Jobs\UpdateEtimProductClasses;
use App\Jobs\UpdateEtimModellingClasses;
use App\Models\Etim\EtimDefinitionSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class DynamicUpdate extends Component
{

    public $name = "Jelly";
    
    public function getEtimStats() 
    {
        if(! $version = EtimDefinitionSet::all()->last()) {
            $version = new EtimDefinitionSet;
            $version->description = "nothing loaded";
            $version->date = "nothing loaded";
        }
        $etimStats = [
            'versionDescription' => $version->description,
            'versionDate' => $version->date,
            'unitCount' => DB::table('etim_units')->where('language', '=', 'EN')->count(),
            'valueCount' => DB::table('etim_values')->count(),
            'featureCount' => DB::table('etim_features')->count(),
            'groupCount' => DB::table('etim_groups')->count(),
            'productClassCount' => DB::table('etim_product_classes')->count(),
            'modellingClassCount' => DB::table('etim_modelling_classes')->count(),
            'translationCount' => DB::table('etim_translations')->count(),
            'synonymCount' => DB::table('etim_synonyms')->count(),
        ];

        return $etimStats; 

    }

    public function getUpdateFileList() 
    {
        $directory = storage_path('app/public/uploads') . "/";
        return  array_diff(scandir($directory), array('..','.'));
    }

    public function render()
    {
        $data = [
            'EtimStats' => $this->getEtimStats(), 
            'UpdateFileList' => $this->getUpdateFileList()
        ];
       
        return view('livewire.etim.dynamic-update', $data);
    }

    public function downloadDynamic (Request $request) 
    {

        $user = Auth::user();
        $date = $request->date;  
            $this->dispatch(new DownloadEtimIXF($user, $date));
            sleep(5);
        return Redirect::route('etim')->with('success', 'Download of ETIM update completed.');
    }
    
    public function updateDynamic (Request $request) 
    {
       
        $user = Auth::user();  
        $date = $request->date;
      
        $update = new EtimDefinitionSet();

        

        $version = $update->findelements("Header", $date);
 
        $update = DB::table('etim_updates')->insert([
            'description' => $version->Description->__toString(),
            'date' => date('d-m-Y', strtotime($version->ExportDate->__toString()))
        ]);

        $this->dispatch(new UpdateEtimUnits($user, $date));
        $this->dispatch(new UpdateEtimValues($user, $date));
        $this->dispatch(new UpdateEtimFeatures($user, $date));
        $this->dispatch(new UpdateEtimGroups($user, $date));
        $this->dispatch(new UpdateEtimProductClasses($user, $date));
        $this->dispatch(new UpdateEtimModellingClasses($user, $date));


        return Redirect::route('etim')->with('success', 'Update of latest ETIM Dynamic definitions in progress.');

    }


}
