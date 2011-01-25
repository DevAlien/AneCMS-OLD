<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of imageclass
 *
 * @author alien
 */
class Image {

    private $name;
    private $logo;
    private $img;
    private $marky;
    private $markx;

    public function  __construct($name) {
        $this->name = $name;

        if($this->getExt($this->name) == 'jpeg' || ($this->getExt($this->name) == 'jpg'))
            $this->img = imagecreatefromjpeg($this->name);
        else
            $this->img = imagecreatefrompng($this->name);
    }

    private function getExt($name) {
         return str_replace('.', '', (strtolower(substr($name, strrpos($name, "."), strlen($name)-strrpos($name, ".")))));
    
    }

    public function createThumb($size, $original = false, $square = false) {
        $old_x=imagesx($this->img);
        $old_y=imagesy($this->img);
        if($square == false) {
            if ($old_x > $old_y) {
                $thumb_w=$size;
                $thumb_h=$old_y*($size/$old_x);
            }
            else if ($old_x < $old_y) {
                $thumb_w=$old_x*($size/$old_y);
                $thumb_h=$size;
            }
            else {
                $thumb_w=$size;
                $thumb_h=$size;
            }
        }
        else {
            $thumb_w=$size;
            $thumb_h=$size;
        }

        $dst_img=imagecreatetruecolor($thumb_w,$thumb_h);
        imagecopyresampled($dst_img,$this->img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

        if($original == true){
            $n = '.';
            $this->img = $dst_img;
        }
        else
            $n = '_thumb.';

        $image=str_replace($this->getExt($this->name), '',$this->name);
        if($this->getExt($this->name) == 'jpeg' || ($this->getExt($this->name) == 'jpg')) {
            $imgname = $image.$n.$this->getExt($this->name);
            $img = imagejpeg($dst_img, $imgname);
        }
        elseif($this->getExt($this->name) == 'png')
            $imgname = $image.$n.$this->getExt($this->name);
            $img = imagepng($dst_img, $imgname);

        imagedestroy($dst_img);
        return $imgname;
    }


    public function setLogo($filename) {
        if($this->getExt($filename) == 'jpeg')
            $this->logo = imagecreatefromjpeg($filename);
        else if($this->getExt($filename) == 'png')
            $this->logo = imagecreatefrompng($filename);
        else
            $this->logo = imagecreatefromgif($filename);
    }

    private function setSizeForMark() {
        $this->markx = (imagesx($this->img)) - imagesx($this->logo);
        $this->marky = (imagesy($this->img)) - imagesy($this->logo);
    }

    public function imageWithMark() {
        $this->setSizeForMark();
        $this->logo_width = imagesx($this->logo);
        $this->logo_height = imagesy($this->logo);
        $a = imagecopy($this->img, $this->logo, $this->markx, $this->marky, 0, 0, $this->logo_width, $this->logo_height);

        $image=explode('.',$this->name);
        if($this->getExt($this->name) == 'jpeg' || ($this->getExt($this->name) == 'jpg'))
            $img = imagejpeg($this->img, $this->name);
        elseif($this->getExt($this->name) == 'png')
            $img = imagepng($this->img, $this->name);

    }

}
?>