<?php
namespace App\CreateFiles;

use Utils\File\FileName;

abstract class BaseCreateFile
{
    protected $converter;

    public function __construct($converter)
    {
        $this->converter = $converter;
    }

    protected function generateFile(String $extension, String $directory): String
    {
        $basename = (new Filename)->generateName();
        return $directory . DIRECTORY_SEPARATOR . sprintf('%s.%0.8s', $basename, $extension);
    }

    protected function writeFile(String $file, $ocr): String
    {
        $fp = fopen($file, 'w');
        fwrite($fp, $ocr);
        fclose($fp);
        return $file;
    }
}