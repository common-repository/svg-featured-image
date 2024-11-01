<?php
    function sfi_nirus_png_create($image, $path_to_write, $orginal_dimensions=false){        
        $im = new Imagick();
        $svg = file_get_contents($image);

        $im->readImageBlob($svg);

        /*png settings*/
        $w = 1200;
        $h=630;
        
        if($orginal_dimensions){
            $d = $im->getImageGeometry();
            $w = $d['width'];
            $h = $d['height'];
        }
        $im->setImageFormat("png24");
        $im->resizeImage($w, $h, imagick::FILTER_LANCZOS, 1);  /*Optional, if you need to resize*/
        $im->writeImage($path_to_write);/*(or .jpg)*/
        $im->clear();
        $im->destroy();
    }
?>
