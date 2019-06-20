<?php
namespace App\CreateFiles;

class ToPDF extends BaseCreateFile implements InterfaceCreateFilesSave
{
    /**
     * Salvar PDF
     *
     * @param String $toConvert
     * @param String $lang
     * @param String $directory
     * @return String
     * @todo Não está funcionando, avaliar futuramente
     */
    public function save(String $toConvert, String $lang, String $directory): String
    {
        $file = $this->generateFile('pdf', $directory);
        $textOCR = $this->converter
            ->image($toConvert)
            ->lang($lang)
            ->pdf()
            ->run();
        return $this->writeFile($file, $textOCR);
    }
}