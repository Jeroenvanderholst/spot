<?php
namespace App\Traits;

use ZipArchive;
 
trait Unpack 
    {
        public function unpack($path, $zipfilename)
        {
        // unzip the arichive
        $zip = new ZipArchive;
        $zip->open($path . $zipfilename);
        $zip->extractTo($path);
        $zip->close();
        unlink($path . $zipfilename);

        }
    }
