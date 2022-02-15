<?php

namespace backend\controllers;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yii;
use yii\web\Controller;

class QrcodeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGenerate()
    {
        $text = Yii::$app->request->get("text");

        $imgContent = $this->initCode($text);
        return $this->asJson(['data' => ['qrcode' => base64_encode($imgContent)]]);
    }

    protected function initCode($text, $writePath = '')
    {
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QrCode::create($text)
            ->setEncoding(new Encoding('UTF-8'))
            //->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            //->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create generic logo
        /*$logo = Logo::create(__DIR__.'/assets/symfony.png')
            ->setResizeToWidth(50);*/
        // Create generic label
        /*$label = Label::create('Label')
            ->setTextColor(new Color(255, 0, 0))
            ->setBackgroundColor(new Color(0, 0, 0));*/
        /*$logo = Logo::create(__DIR__.'/assets/symfony.png')
            ->setResizeToWidth(50);*/

        $result = $writer->write($qrCode, null, null);

        // Directly output the QR code
        //header('Content-Type: '.$result->getMimeType());
        return $result->getString();

        // Save it to a file
        //$result->saveToFile(__DIR__.'/../runtime/qrcode/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        //$dataUri = $result->getDataUri();
    }
}