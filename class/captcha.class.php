<?php

class Captcha{

    private $code;

    public function createImage(){
        $im = imagecreatetruecolor(40, 15);
        $text_color = imagecolorallocate($im, 255, 255, 255);

        imagestring($im, 5, 2, 0,  $this->randomize(), $text_color);

        ob_start();
        imagejpeg($im, NULL, 100);
        $contents = ob_get_contents();
        ob_end_clean();
        return "<img src='data:image/png;base64,".base64_encode($contents)."' />";
    }

    private function randomize(){
        $this->code = rand(1000,9999);
        return $this->code;
    }

    public function getCode(){
        return $this->code;
    }
}
?>
