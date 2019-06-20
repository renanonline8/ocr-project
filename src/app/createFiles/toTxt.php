<?php
namespace App\CreateFiles;

class ToTxt extends BaseCreateFile implements InterfaceCreateFilesSave
{
    public function save(String $toConvert, String $lang, String $directory): String
    {
        $file = $this->generateFile('txt', $directory);
        $textOCR = $this->converter
            ->image($toConvert)
            ->lang($lang)
            ->txt()
            ->run();
        return $this->writeFile($file, $textOCR);
    }
}