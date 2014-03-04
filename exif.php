<?php
function imageFlip($i, $m){
    $width = imagesx($i);
    $height = imagesy($i);
    $i_x = 0;
    $i_y = 0;
    $i_w = $width;
    $i_h = $height;
    switch($m){
        case 1: //vertical
            $i_y = $height -1;
            $i_h = -$height;
        	break;
        case 2: //horizontal
            $i_x = $width -1;
            $i_w = -$width;
        	break;
    }
    $newImg = imagecreatetruecolor($width, $height);
    if(imagecopyresampled($newImg, $i, 0, 0, $i_x, $i_y, $width, $height, $i_w, $i_h)){
        return $newImg;
    }else{
    	return $i;
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