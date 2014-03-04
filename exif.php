<?php
function imageFlip($imgsrc, $mode){
    $width = imagesx($imgsrc);
    $height = imagesy($imgsrc);
    $src_x = 0;
    $src_y = 0;
    $src_width = $width;
    $src_height = $height;
    switch($mode){
        case 1: //vertical
            $src_y = $height -1;
            $src_height = -$height;
        	break;
        case 2: //horizontal
            $src_x = $width -1;
            $src_width = -$width;
        	break;
    }
    $imgdest = imagecreatetruecolor($width, $height);
    if(imagecopyresampled($imgdest, $imgsrc, 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height)){
        return $imgdest;
    }else{
    	return $imgsrc;
    }
}
function orient($img){
	$imgData = exif_read_data($img);
	$newImg = imagecreatefromjpeg($img);
	$o = intval($imgData['Orientation']);
	$degrees = 0;
	//echo $o;
	switch($o){
		case 1: //already the right orientation
			$degrees = 0;
			break;
		case 2: // horizontal
			$newImg = imageFlip($newImg, 2);
			$degrees = 0;
			break;
		case 3: // 180deg left
			$degrees = 180;
			break;
		case 4: // vertical
			$newImg = imageFlip($newImg, 1);
			$degrees = 0;
			break;
		case 5: // vertical & 90deg right
			$newImg = imageFlip($newImg, 1);
			$degrees = -90;
			break;
		case 6: // 90deg right
			$degrees = -90;
			break;
		case 7: // horizontal & 90deg right
			$newImg = imageFlip($newImg, 2);
			$degrees -90;
			break;
		case 8: // 90deg left
			$degrees = 90;
			break;
	}
	if($degrees != 0){
		$newImg = imagerotate($newImg, $degrees, -1);
	}
	header('Content-type: image/jpeg');
	imagejpeg($newImg);//return this for new oriented image, just outputs result to browser for now.
	imagedestroy($newImg);
}
orient('/path/to/img');
?>