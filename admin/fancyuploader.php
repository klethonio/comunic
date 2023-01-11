<?php
require_once('../dts/dbaSis.php');

if (!empty($_FILES)) {
	$postId		= $_POST['postId'];
    $img        = $_FILES['galleryFile']['name'];
	$ext        = strrchr($img, '.');
	$img        = $postId.'-'.md5(uniqid(time())).$ext;
	$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
	$m = date('m');
	$y = date('Y');
	if(!file_exists($targetPath.$y)){ mkdir($targetPath.$y);}
	if(!file_exists($targetPath.$y.'/'.$m)){ mkdir($targetPath.$y.'/'.$m);}
	$targetPath = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$y.'/'.$m.'/';
	$tempFile = $_FILES['galleryFile']['tmp_name'];
	$targetFile =  str_replace('//','/',$targetPath).$img;
	
	$imgCad = $y.'/'.$m.'/'.$img;
	$timestamp = date('Y-m-d H:i:s');
	$data = array('post_id'=>$postId, 'img'=>$imgCad, 'date'=>$timestamp);
	create('cuc_gallery', $data, 'iss');
	
	move_uploaded_file($tempFile,$targetFile);
	str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);

	$imgsize = getimagesize($targetFile);
	switch(strtolower(substr($targetFile, -3))){
		case "jpg":
			$image = imagecreatefromjpeg($targetFile);    
		break;
		case "png":
			$image = imagecreatefrompng($targetFile);
		break;
		case "gif":
			$image = imagecreatefromgif($targetFile);
		break;
		default:
			exit;
		break;
	}

	$width = 800;  
	$height = $imgsize[1]/$imgsize[0]*$width;

	$src_w = $imgsize[0];
	$src_h = $imgsize[1];

	$picture = imagecreatetruecolor($width, $height);
	imagealphablending($picture, false);
	imagesavealpha($picture, true);
	$bool = imagecopyresampled($picture, $image, 0, 0, 0, 0, $width, $height, $src_w, $src_h); 

	if($bool){
		switch(strtolower(substr($targetFile, -3))){
			case "jpg":
				header("Content-Type: image/jpeg");
				$bool2 = imagejpeg($picture,$targetPath.$img,100);
				break;
			case "png":
				header("Content-Type: image/png");
				imagepng($picture,$targetPath.$img);
				break;
			case "gif":
				header("Content-Type: image/gif");
				imagegif($picture,$targetPath.$img);
				break;
		}
	}

	imagedestroy($picture);
	imagedestroy($image);

	// $response = [
	// 	"success" => false,
	// 	"error" => "Human-readable, possibly translated error.",
	// 	"errorcode" => "relevant_error_code"
	// ];

}

echo json_encode(['success' => true]);
