<?php namespace App\Interactors;

use App\Data\CertificateData;
use App\Util\ImageDrawer;

class CertificateImageMaker
{
    /* @var ImageDrawer */
    private $imageDrawer;

    public function __construct()
    {
        $certificateDir = base_path('resources') . DIRECTORY_SEPARATOR . 'certificate';
        $imagePath = $certificateDir . DIRECTORY_SEPARATOR . 'cert.png';
        $fontDir = $certificateDir . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;

        $this->imageDrawer = new ImageDrawer($imagePath, $fontDir, 'certificate');
    }

    public function close()
    {
        $this->imageDrawer->closeImage();
    }

    public function makeImage(CertificateData $data, $targetPath)
    {
        $titleFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . 'i700.ttf';
        $titleFontSize = 28;

        $defaultFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . '400.ttf';
        $dateFontSize = 25;
		if(strlen($data->getCourseName())>120) $dateFontSize = 22;

        $this->imageDrawer->drawString($data->getFullName(), $titleFontSize, 640 /*750*/, 670 /*746*/, $titleFontPath);
        $this->imageDrawer->drawString($data->getCourseName(), $dateFontSize, 170, 770 /*850*/, $defaultFontPath);
        $this->imageDrawer->drawString($data->getDuration(), $dateFontSize, 800, 860 /*950*/, $defaultFontPath);

        $dateYPos = 1230 /*1300*/;
        $this->imageDrawer->drawString($data->getDay(), $dateFontSize, 472 /*483*/, $dateYPos, $defaultFontPath);
        $this->imageDrawer->drawString($data->getMonth(), $dateFontSize, 535 /*583*/, $dateYPos, $defaultFontPath);
        $this->imageDrawer->drawString($data->getYear(), 27, 790 /*583*/, 1230, $defaultFontPath);


	    $this->imageDrawer->drawString($data->get_reg_number(), $dateFontSize, 1685 /*1790*/, 1280 /*1350*/, $defaultFontPath);

		$this->imageDrawer->drawString($data->get_sign2(), $dateFontSize, 1700, 1100, $defaultFontPath);
		$this->imageDrawer->drawString($data->get_sign1(), $dateFontSize, 650, 1100, $defaultFontPath);

        $this->imageDrawer->savePng($targetPath);
    }

}


