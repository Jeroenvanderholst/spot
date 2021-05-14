<?php

namespace App\Models\Etim;

use XMLReader;
use App\Traits\Unpack;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EtimUpdate extends Model
{
    use HasFactory;
    use Unpack;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    { 
     
        $this->path = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR ;
        $this->date = new \DateTime('-1 days');
        $this->zipfilename = "ETIMIXFMC2_0_" . $this->date->format('Ymd') . '.zip';
        $this->filename = "ETIMIXFMC2_0_" . $this->date->format('Ymd') . '.xml';
        
        
    }
   
    /**
     * Download and unzip the latest Dynamic ETIM file from the 
     * ETIM International server
     *
     * @param  mixed $date
     * @return void
     */
    public function download($date)
    {
        if ($date) {
            $this->zipfilename = "ETIMIXFMC2_0_" . $date . '.zip';
        }
        
        $download_from = config('etim.base_url') . $this->zipfilename;
        $download_to = $this->path . $this->zipfilename;
        // ddd($download_from, $download_to);
        if (!copy($download_from, $download_to)) {
            $errors = error_get_last();
            $message = "COPY ERROR: " . $errors['type'] . "<br />\n" . $errors['message'];
            Log::error($message);
            throw new \Exception($message);
            } else {
            return true;
        }

       
    }

         
    /**
     * Retrieves elements from an XML document
     * using XML reader and stores it into a simpleXML object.
     *
     * @param  mixed $element
     * @param  mixed $date
     * @return void
     */
    public function findElements($element, $date)
    {

        if ($date) {
            $this->filename = "ETIMIXFMC2_0_" . $date . '.xml';
        }
        $reader = new XMLReader();

        // dd($this->path.$this->filename);

        $reader->open($this->path . $this->filename) ;

        //skip the root element so we can use the $reader->next() method

        //    $reader->next($element);
        $result = [];
        
        while ($reader->read()) {
            
            while ($reader->name !== "Header") {
                // echo($reader->name. "\n");
                $reader->read();
            }
            
            if ($reader->name !== $element) {
                $reader->next($element);                
            }


            if ($reader->name == $element && $reader->nodeType == XMLReader::ELEMENT) {
                
                $result = simplexml_load_string($reader->readOuterXml());
                            
            return $result;   
            
            }  
        
        }
        $reader->close();
    }

}
