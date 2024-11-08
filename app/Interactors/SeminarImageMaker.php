<?php namespace App\Interactors;

use App\Data\DiplomaData;
use App\Util\ImageDrawer;

class SeminarImageMaker
{
    /* @var ImageDrawer */
    private $imageDrawer;

    public function __construct($folder, $filename)
    {
        $certificateDir = base_path('resources') . DIRECTORY_SEPARATOR . $folder;
        $imagePath = $certificateDir . DIRECTORY_SEPARATOR . $filename;
        $fontDir = $certificateDir . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;

        $this->imageDrawer = new ImageDrawer($imagePath, $fontDir, 'letter');
    }

    public function close()
    {
        $this->imageDrawer->closeImage();
    }

    public function makeImage(DiplomaData $data, $targetPath)
    {
        $titleFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . 'i400.ttf';
        $titleFontSize = 85;

        $defaultFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . '700.ttf';
        $dateFontSize = 30;

        $this->imageDrawer->drawString($data->getFullName(), $titleFontSize, 790, 565, $titleFontPath, [0, 0, 0], true, 1000);

        $dateYPos = 1380;
        $this->imageDrawer->drawString($data->getDay(), $dateFontSize, 930, $dateYPos, $defaultFontPath, [0, 0, 0]);
        $this->imageDrawer->drawString($data->getMonth(), $dateFontSize, 981, $dateYPos, $defaultFontPath, [0, 0, 0]);
        $this->imageDrawer->drawString($data->getYear(), $dateFontSize, 1030, $dateYPos, $defaultFontPath, [0, 0, 0]);

        $this->imageDrawer->drawString($data->get_reg_number(), $dateFontSize, 1640, 1380, $defaultFontPath);

        $this->imageDrawer->savePng($targetPath);
    }

}


