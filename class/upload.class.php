<?php
/**
 * Class to upload files
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */

/**
 * Class to upload files
 *
 * @package ANECMS
 * @author Goncalo Margalho <gsky89@gmail.com>
 * @copyright anemcs.Com (C) 2008-2010
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class Upload{

    private $upload_dir;
    private $max_file_size;
    private $files_type;
    private $max_size;

    public function __construct(){
        //set 5MB file size
        $this->max_size = 5242880;

        //common audio file type
        $ext_str = "acc,aif,iff,m3u,m4a,mid,midi,mp3,mpa,ra,ram,wav,wma,jpg,jpeg,gif,png,bmp,tiff";
        $this->files_type = explode(",",$ext_str);

    }

    public function upload_file($upload_dir="", $file_name = false){
        if(!$_FILES['error'])
            foreach($_FILES as $form_name=>$file_arr)
                $this->file = $file_arr;

        if($file_name)
            $this->name = $file_name;
        else
            $this->name = time().$this->file['name'];

        if($upload_dir){
            if(is_dir($upload_dir))
                $this->upload_dir = $upload_dir;
            else
                return false;
        }
        else
            $this->upload_dir = "./";


        $ext = substr($this->file['name'], strrpos($this->file['name'], '.') + 1);
        if (in_array($ext, $this->files_type) ) {
            if($this->file['size']<=$this->max_size){
            if (move_uploaded_file($this->file['tmp_name'],$this->upload_dir ."/". $this->name)) {
                    return $this->upload_dir ."/". $this->name;
            }else {
                    return false;
            }
            
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
?>
