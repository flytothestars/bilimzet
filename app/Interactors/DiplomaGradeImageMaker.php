<?php namespace App\Interactors;

use App\Data\DiplomaData;
use App\Util\ImageDrawer;

class DiplomaGradeImageMaker
{
    /* @var ImageDrawer */
    private $imageDrawer;

    public function __construct($folder, $filename)
    {
        $certificateDir = base_path('resources') . DIRECTORY_SEPARATOR . $folder;
        $imagePath = $certificateDir . DIRECTORY_SEPARATOR . $filename;
        $fontDir = $certificateDir . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR;

        $this->imageDrawer = new ImageDrawer($imagePath, $fontDir, 'diploma');
    }

    public function close()
    {
        $this->imageDrawer->closeImage();
    }

    public function makeImage(DiplomaData $data, $targetPath)
    {
        $titleFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . 'i400.ttf';
        $titleFontSize = 70;

        $defaultFontPath = 'TimesNewRoman' . DIRECTORY_SEPARATOR . '700.ttf';
        $courseFontSize = 40;
        $dateFontSize = 37;

		if (strlen($data->getCourseName()) > 120) $courseFontSize = 30;

        $this->imageDrawer->drawString($data->getFullName(), $titleFontSize, 790, 930, $titleFontPath, [246, 35, 35], true);
        $this->imageDrawer->drawString($data->getSurname(), $titleFontSize, 790, 1015, $titleFontPath, [246, 35, 35], true);
        $this->imageDrawer->drawString($data->getCorrectAnswers(), 47, 1000, 1550, $defaultFontPath, [246, 35, 35]);

        if (strlen($data->getCourseName()) >= 73) {
            $courseNameSplit = explode(' ', $data->getCourseName());
            $wordsCount = count($courseNameSplit);
            $wordLines = round($wordsCount / 2);

            $textTop = array_slice($courseNameSplit, 0, $wordLines);
            $textBottom =  array_slice($courseNameSplit, $wordLines, $wordLines);

            $this->imageDrawer->drawString(implode(" ", $textTop), $courseFontSize, 692, 1270, $defaultFontPath, [246, 35, 35], true);
            $this->imageDrawer->drawString(implode(" ", $textBottom), $courseFontSize, 692, 1340, $defaultFontPath, [246, 35, 35], true);
        } else {
            $this->imageDrawer->drawString($data->getCourseName(), $courseFontSize, 692, 1340, $defaultFontPath, [246, 35, 35], true);
        }

        $dateYPos = 1942;
        $this->imageDrawer->drawString($data->getDay(), $dateFontSize, 30, $dateYPos, $defaultFontPath, [246, 35, 35]);
        $this->imageDrawer->drawString($data->getMonth(), $dateFontSize, 92, $dateYPos, $defaultFontPath, [246, 35, 35]);
        $this->imageDrawer->drawString($data->getYear(), $dateFontSize, 155, $dateYPos, $defaultFontPath, [246, 35, 35]);

	    $this->imageDrawer->drawString($data->get_reg_number(), 45, 1070, 1940, $defaultFontPath);

        $this->imageDrawer->savePng($targetPath);
    }

}


