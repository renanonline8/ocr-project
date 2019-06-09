<?php
namespace App\CreateFiles;

use Utils\File\FileName;

class ToTxt
{
    private $converter;

    public function __construct($converter)
    {
        $this->converter = $converter;
    }

    public function save(String $toConvert, String $lang, String $directory):String
    {
        $basename = (new Filename)->generateName();
        $extension = 'txt';
        $file = $directory . DIRECTORY_SEPARATOR . sprintf('%s.%0.8s', $basename, $extension);
        $textOCR = $this->converter
            ->image($toConvert)
            ->lang($lang)
            ->txt()
            ->run();
        $fp = fopen($file, 'w');
        fwrite($fp, $textOCR);
        fclose($fp);
        return $file;
    }
}