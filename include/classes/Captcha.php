<?php
/**
 * Methods for re-creating image from the source and splitting to become another smaller cropped image.
 *
 * @link          http://example.com CAPTCHA Project
 */
 
 /**
 * Captcha.
 *
 * Class holding everything that is used for re-creating image from the source and splitting to become another smaller cropped image.
 *
 * @package       -
 * @subpackage    -
 */
class Captcha {

    var $sources = null;
    var $documentRoot = null;
    var $domainRoot = null;
    
/**
 * Constructor
 *
 * @param -.
 * @return CaptchaClass
 */ 
    function __construct() {
        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];
        $this->domainRoot = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $imgSourceDir = $this->documentRoot.'source';
        $this->sources = array();
        foreach(scandir($imgSourceDir) as $k=>$v) {
            if($v != '.' && $v != '..') $this->sources[$k] = $imgSourceDir.DIRECTORY_SEPARATOR.$v;
        }
    }

/**
 * Re-create image with GD and split into smaller cropped images.
 *
 * @param -.
 * @return array images and its properties
 * @access public
 */
    function imgSplit() {
        shuffle($this->sources);
        $options = array('watermark'=>CAPTCHA_IS_WATERMARK,'cols'=>CAPTCHA_COL,'rows'=>CAPTCHA_ROW);
        $prefix = sha1($this->sources[0]);
	    $source = @imagecreatefromjpeg( $this->sources[0] );

	    $source_width = imagesx( $source );
	    $source_height = imagesy( $source );

	    $w_percentage = CAPTCHA_WIDTH/$source_width;
	    $h_percentage = CAPTCHA_WIDTH/$source_height;
	    
	    if(CAPTCHA_WIDTH == null && CAPTCHA_HEIGHT == null) $w_percentage = $h_percentage = 1;
	    
	    $newWidth = $source_width*$w_percentage;
	    $newHeight = $source_height*$h_percentage;

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newWidth, $newHeight, $source_width, $source_height);

        $source = $newImage;

	    $source_width = $newWidth;
	    $source_height = $newHeight;

	
	    $width = $source_width/$options['cols'];
	    $height = $source_height/$options['rows'];
	    
	    $wraps = array();
	    $valids = array();
	    $i=1;
	    for( $row = 0; $row < $source_height / $height; $row++){
		    for( $col = 0; $col < $source_width / $width; $col++) {
		        $file = $prefix.'_'.$col.'_'.$row.'.png';
		        $dest = $this->documentRoot.'temp'.DIRECTORY_SEPARATOR.$file;
			    $im = @imagecreatetruecolor( $width, $height );
			    imagecopyresized( $im, $source, 0, 0,
				    $col * $width, $row * $height, $width, $height,
				    $width, $height );
				    
                //Create watermark numerik.
                if($options['watermark']) $im = $this->__createWatermark($im,$width,$height,$i);

                if(imagepng( $im, $dest )) {
                    $wraps[] = $file;
                    $valids[] = sha1($file);
                }else {
                    imagedestroy( $im );
                    return false;
                }
			    imagedestroy( $im );
			    $i++;
            }
        }

        $return = array(
            'width'=>$source_width,
            'height'=>$source_height,
            'valid'=>sha1(CAPTCHA_SALT.json_encode($valids)),
            'images'=>$wraps
        );
        return $return;    
    }
    
/**
 * Add a indexed watermark.
 *
 * @param string $im Resource ID for the image.
 * @param integer $width Width of the image.
 * @param integer $height Height of the image.
 * @param string $text Teks string for the watermark.
 * @return string Resource ID of the watermarked image.
 * @access protected
 */
    function __createWatermark($im=null,$width=null,$height=null,$text=null) {
	    $stamp = @imagecreatetruecolor($width, $height);
	    imagecopyresampled($stamp, $im, 0, 0, 0, 0, $width, $height, $width, $height);
        
        $color = imagecolorallocatealpha($stamp, 0, 0, 0, 0x50);
        $letter_color = imagecolorallocate($stamp, 255, 255, 255);
        imagefilledellipse($stamp, 32, 20, 50, 35, $color);
        imagettftext($stamp, 25, 0, 20, 33, $letter_color, 'ttf-japanese-gothic.ttf', $text);
        return $stamp;
    }
}
