<?php
namespace App\Controller;

use \SlimUtils\Controller\BaseController;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\CreateFiles\ToTxt;
use App\CreateFiles\ToPDF;

final class ConvertController extends BaseController
{
    /**
     * Convert image using OCR
     *
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return void
     * @todo Marcar tempo da conversão e tamanho do arquivo
     * @todo Validar linguas disponíveis
     */
    public function convert(Request $request, Response $response, Array $args)
    {
        //Get Body
        $body = $request->getParsedBody();

        //Upload image
        $directory = $this->toConvertDir;
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['image'];
        if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
            return $response->write('Não deu certo o upload');
        }
        $filename = $this->upload->moveUploadedFile($directory, $uploadedFile);
        $this->logger->debug('Upload realizado com sucesso', ['file' => $filename]);

        //Convert to OCR
        $imagePath = $directory. DIRECTORY_SEPARATOR . $filename; 
        $textOCR = $this->tesseract
            ->image($imagePath)
            ->lang($body['lang'])
            ->run();
        $this->logger->debug('Converted to string: ' . $imagePath);

        //Convert to Txt
        //$toTxt = new ToTXT($this->tesseract);
        //$localTxt = $toTxt->save($imagePath, $body['lang'], $this->toTxtDir);
        //$this->logger->debug('Converted to TXT, it is ' . $localTxt);

        //Convert to PDF
        //$toPDF = new ToPDF($this->tesseract);
        //$localPDF = $toPDF = $toPDF->save($imagePath, $body['lang'], $this->toPDFDir);
        //$this->logger->debug('Converted to PDF, it is ' . $localTxt);
        
        //Response
        $resArr['success'] = true;
        $resArr['text'] = $textOCR;
        //$resArr['pathToTxt'] = $localTxt;
        //$resArr['pathToPDF'] = $localPDF;
        return $response->withJson($resArr);
    }

}