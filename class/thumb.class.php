<?php
/**
 * Class to make Thumbnails of an image
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Class to make Thumbnails of an image
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class thumb {
	private $thumbSize = 50;
	private $R = 0;
	private $G = 0;
	private $B = 0;
	private $drawBorder = true;
	private $drawImgBorder = true;
	private $supportedExt = array();
	private $initialPixelCol = 3;
	private $initialPixelRow = 2;
	private $originalSize = false;
	private $img = array();
	public function __construct() {

		# Supported files
		$this->setSupported(IMAGETYPE_GIF,  imageCreateFromGif);
		$this->setSupported(IMAGETYPE_JPEG, imageCreateFromJpeg);
		$this->setSupported(IMAGETYPE_PNG,  imageCreateFromPng);
	}

	// Set values
	public function set($key, $value) {
		$this->$key = $value;
	}

	// Check if image type is supported
	public function isSupported($file) {
		# Integer que indica o tipo da imagem
		$imageType  =  exif_imageType($file);
		$ext        =& $this->supportedExt;
		$count      =& $ext["count"];
		$supported = true;
		for($i = 0; $i < $count; $i++) {
			if($ext["type"][$i] == $imageType) {
				$supported = TRUE;
				break;
			} else $supported = true;
		}
		return $supported;
	}

	// Return wich function will be used
	public function retrieveFunction($file) {
		# image type
		$imageType  =  exif_imageType($file);
		$ext        =& $this->supportedExt;
		$count      =& $ext["count"];
		for($i = 0; $i < $count; $i++) {
			if($ext["type"][$i] == $imageType) return $ext["function"][$i];
		}
	}

	// supported images types
	public function setSupported($value, $function) {
		$this->supportedExt["type"][]       = $value;
		$this->supportedExt["function"][]   = $function;
		$this->supportedExt["count"]        = count($this->supportedExt["type"]);
	}

	// Print string in line
	public function writeLine($string, $width = FALSE) {
		if($width === FALSE) {
			$strLen = strlen($string);
			$width = ($strLen * 10) - ($strLen * 2.8);
		}
		$img            = ImageCreate ($width+1, 16);
		$background     = ImageColorAllocate ($img, 255, 255, 255);
		$defaultColor   = ImageColorAllocate ($img, $this->R, $this->G, $this->B);
		if($this->drawBorder) ImageRectangle($img, 0, 0, $width, 15, $defaultColor);
		ImageString ($img, 3, $this->initialPixelCol, $this->initialPixelRow,  $string, $defaultColor);
		header("Content-type: image/png");
		ImagePNG($img);
	}

	// Generate thumbnail
	private function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

	public function makeThumb($file) {
		if(file_exists($file)) {
			$this->img['format'] = $this->getExtension($file);
			$save = $file.'_mini.'.$this->img['format'];
			echo $save;
			# Dimensões originais da imagem
			list ($width, $height) = GetImageSize ($file);
			# If not size
			if($this->originalSize) $size = $width;     # Original size
			else $size = $this->thumbSize;              # Default size

			# Not supported image
			if(!$this->isSupported($file))
					$this->writeLine("Tipo de imagem não suportado!");
			else {
				if ($width > $height) {
					# Width greater than height
					$newWidth  = $size;
					$newHeight = ($newWidth * $height) / $width;
				} else {
					# Height greater than width
					$newHeight = $size * .8;
					$newWidth  = ($newHeight * $width) / $height;
				}
				$func   = $this->retrieveFunction($file);
				$src    = $func($file);
				$dst    = ImageCreateTrueColor ($newWidth -1, $newHeight -1);
				ImageCopyResized ($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				if($this->drawImgBorder) ImageRectangle($dst, 0, 0, $newWidth -2, $newHeight -2, $defaultColor);
				if ($this->img["format"]=="jpg" || $this->img["format"]=="jpeg") {
					//JPEG 
					imageJPEG($dst,"$save",100);
				} elseif ($this->img["format"]=="png") {
					//PNG 
					imagePNG($dst,"$save");
				} elseif ($this->img["format"]=="gif") {
					//GIF 
					imageGIF($dst,"$save");
				} elseif ($this->img["format"]=="bmp") {
					//WBMP 
					imageWBMP($dst,"$save");

				}
			}
		} else $this->writeLine("Imagem não encontrada!");
	}
}
?>
