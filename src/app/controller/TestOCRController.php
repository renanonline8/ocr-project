<?php
namespace App\Controller;

use \SlimUtils\Controller\BaseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \thiagoalessio\TesseractOCR\TesseractOCR;

final class TestOCRController extends BaseController
{
    
    public function convert(Request $request, Response $response, Array $args)
    {
        $imagePath = __DIR__ . '/../../../uploads/images/to_convert/magazine_example_02.png';
        $textOCR = $this->tesseract->image($imagePath)->lang('por')->run();
        return $response->write($textOCR);
    }

    public function langAvailable(Request $request, Response $response, Array $args)
    {
        $langs = 'Available Languages:<br>';
        foreach ($this->tesseract->availableLanguages() as $lang) {
            $langs .= $lang . '<br>';
        }
        return $response->write($langs);
    }

    public function version(Request $request, Response $response, Array $args)
    {
        return $response->write($this->tesseract->version());
    }
}