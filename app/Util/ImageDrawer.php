<?php


namespace App\Util;


class ImageDrawer
{
    /* @var resource */
    private $image;

    /* @var resource */
    private $color;

    /* @var string */
    private $fontDir;

    /* @var int */
    private $imageWidth;

    /* @var int */
    private $imageHeight;

    /* @var string */
    private $type;

    public function __construct($imagePath, $fontDir, $type = null)
    {
        $this->image = imagecreatefrompng($imagePath);
        $this->imageWidth = imagesx($this->image);
        $this->imageHeight = imagesy($this->image);
        $this->type = $type;

        $this->color = imagecolorallocate($this->image, 0, 0, 0);
        $this->fontDir = realpath($fontDir);
    }

    public function drawString($text, $textSize, $xPos, $yPos, $fontRelativePath, $color = [], $autoXPosition = false, $middleOfWhiteBox = 707, $xPosBoxFromLeftToWhite = 50)
    {
        $fontPath = realpath($this->fontDir . DIRECTORY_SEPARATOR . $fontRelativePath);
		$arr = explode(' ', $text);
		$ret = "";$ret1="";
		$width_text = 150;

		if (!empty($color)) {
            list($red, $green, $blue) = $color;

		    $this->color = imagecolorallocate($this->image, $red, $green, $blue);
        }

		foreach($arr as $word)
	{
		//$tmp_string = $ret.' '.$word;
		// $textbox = imagettfbbox($font_size, 0, $font, $tmp_string);
		
		if(strlen($ret) > $width_text)
			{$ret.=($ret==""?"":"\n").$word;$ret1.=$ret;$ret="";}
		else
			$ret.=($ret==""?"":" ").$word;
	}
		$ret1.=$ret;

		if ($autoXPosition && $this->type == 'diploma') {
            $dimensions = imagettfbbox($textSize, 0, $fontPath, $text);

            $xPos = $xPosBoxFromLeftToWhite + ($middleOfWhiteBox - ($dimensions[4] / 2));
        } elseif ($autoXPosition && $this->type == 'letter') {
            $dimensions = imagettfbbox($textSize, 0, $fontPath, $text);

            $xPos = $xPosBoxFromLeftToWhite + ($middleOfWhiteBox - ($dimensions[4] / 2));
        }

        imagettftext($this->image, $textSize, 0, $xPos, $yPos,
            $this->color, $fontPath, $text);
    }

    public function savePng($path)
    {
        imagepng($this->image, $path);
    }

    public function closeImage()
    {
        imagedestroy($this->image);
    }
}
