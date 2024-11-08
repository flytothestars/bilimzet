<?php namespace App\Interactors;

use App\Data\DiplomaData;
use App\Util\ImageDrawer;

class LetterNewImageMaker
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
        $titleFontSize = 55;

        $defaultFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . '700.ttf';
        $courseFontSize = 40;
        $dateFontSize = 30;

        if (strlen($data->getCourseName()) > 120) $courseFontSize = 30;

        $this->imageDrawer->drawString($data->getFullName() . ' ' . $data->getSurname(), $titleFontSize, 790, 680, $titleFontPath, [236, 35, 35], true, 1000, 0);

        if (strlen($data->getCourseName()) >= 73) {
            $courseNameSplit = explode(' ', $data->getCourseName());
            $wordsCount = count($courseNameSplit);
            $wordLines = round($wordsCount / 2);

            $textTop = array_slice($courseNameSplit, 0, $wordLines);
            $textBottom =  array_slice($courseNameSplit, $wordLines, $wordLines);

            $this->imageDrawer->drawString(implode(" ", $textTop), $courseFontSize, 692, 955, $defaultFontPath, [236, 35, 35], true, 1000, 0);
            $this->imageDrawer->drawString(implode(" ", $textBottom), $courseFontSize, 692, 1005, $defaultFontPath, [236, 35, 35], true, 1000, 0);
        } else {
            $this->imageDrawer->drawString($data->getCourseName(), $courseFontSize, 692, 1005, $defaultFontPath, [236, 35, 35], true, 1000, 0);
        }

        $dateYPos = 912;
        $this->imageDrawer->drawString($data->getDay(), $dateFontSize, 870, $dateYPos, $defaultFontPath, [236, 35, 35]);
        $this->imageDrawer->drawString($data->getMonth(), $dateFontSize, 915, $dateYPos, $defaultFontPath, [236, 35, 35]);
        $this->imageDrawer->drawString($data->getYear(), $dateFontSize, 965, $dateYPos, $defaultFontPath, [236, 35, 35]);

        $this->imageDrawer->drawString($data->get_reg_number(), $dateFontSize, 940, 1320, $defaultFontPath);

        $this->imageDrawer->savePng($targetPath);
    }

}


