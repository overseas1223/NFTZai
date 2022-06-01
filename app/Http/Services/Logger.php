<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\File;

/**  * Logger class  */
class Logger
{
    private $path;
    public function __construct($path=null)
    {
        if(is_null($path)) {
            $this->path = storage_path().'/logs/'.'default.log';
        } else {
            $this->path = $path;
        }
        if (!(File::exists($this->path))) {
            File::put($this->path, '');
        }
    }

    public function log($type, $text = '', $timestamp = true)
    {
        if(gettype($text) == 'array'){
            $text = json_encode($text);
        }
        if ($timestamp) {
            $datetime = date("d-m-Y H:i:s");
            $text = "$datetime, $type: $text \r\n\r\n";
        } else {
            $text = "$type\r\n\r\n";
        }

        error_log($text, 3, $this->path);
    }

}

