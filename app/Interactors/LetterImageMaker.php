<?php namespace App\Interactors;

use App\Data\DiplomaData;
use App\Util\ImageDrawer;

class LetterImageMaker
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
        $courseFontSize = 40;
        $dateFontSize = 30;

        if (strlen($data->getCourseName()) > 120) $courseFontSize = 30;

        $this->imageDrawer->drawString($data->getFullName(), $titleFontSize, 790, 380, $titleFontPath, [35, 117, 212], true);
        $this->imageDrawer->drawString($data->getCourseName(), $courseFontSize, 692, 750, $defaultFontPath, [59, 24, 29], true);
        $this->imageDrawer->drawString($data->getSurname(), $titleFontSize, 790, 480, $titleFontPath, [35, 117, 212], true);

        $dateYPos = 1030;
        $this->imageDrawer->drawString($data->getDay(), $dateFontSize, 470, $dateYPos, $defaultFontPath, [59, 24, 29]);
        $this->imageDrawer->drawString($data->getMonth(), $dateFontSize, 520, $dateYPos, $defaultFontPath, [59, 24, 29]);
        $this->imageDrawer->drawString($data->getYear(), $dateFontSize, 570, $dateYPos, $defaultFontPath, [59, 24, 29]);

        $this->imageDrawer->drawString($data->get_reg_number(), $dateFontSize, 1220, 1380, $defaultFontPath);

        $this->imageDrawer->savePng($targetPath);
    }

}


