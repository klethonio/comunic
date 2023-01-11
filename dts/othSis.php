<?php

function dd(): void
{
    echo '<pre class="debug">';

    foreach (func_get_args() as $var) {
        echo '<hr>';
        var_dump($var);
        echo '<hr>';
    }

    echo '</pre>';
    die;
}
/***********************************
FUNÇÃO RESUMIR
***********************************/
function resText($string, $words=100){
	$string = strip_tags($string);
	if(strlen($string) <= $words){
		return $string;
	}else{
		$strrpos = strrpos(substr($string, 0, $words), ' ');
		return substr($string, 0, $strrpos).'...'; 
	}
}
/***********************************
FUNÇÃO VALIDAR CPF
***********************************/
function validCPF($cpf){
	$cpf = preg_replace('/[^0-9]/','',$cpf);
	$digitoA = 0;
	$digitoB = 0;
	for($i=0, $x=10;$i<=8;$i++, $x--){
		$digitoA += $cpf[$i] * $x;
	}
	for($i=0, $x=11;$i<=9;$i++, $x--){
		if(str_repeat($i, 11)==$cpf){
			return false;
		}
		$digitoB += $cpf[$i] * $x;
	}
	$somaA = ($digitoA%11 < 2)?0:11-($digitoA%11);
	$somaB = ($digitoB%11 < 2)?0:11-($digitoB%11);
	if($somaA != $cpf[9] || $somaB != $cpf[10]){
		return false;
	}else return true;
}
/***********************************
FUNÇÃO VALIDAR E-MAIL
***********************************/
function validMail($mail){
	if(preg_match("/^[^0-9.\-][a-z0-9_\.\-]+@[a-z0-9]+[a-z0-9_\.\-]*[.][a-z]{2,4}$/",$mail)){
		return true;
	}
}
/***********************************
FUNÇÃO ENVIAR E-MAIL
***********************************/
function sendMail($subject,$message,$from,$fromName,$to,$toName, $reply = NULL, $replyName = NULL){
	include_once('mail/class.phpmailer.php'); //Include pasta/classe do PHPMailer
	$mail = new PHPMailer(); //INICIA A CLASSE
	$mail->IsSMTP(); //Habilita envio SMPT
	$mail->SMTPAuth = true; //Ativa email autenticado
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	//$mail->SMTPDebug  = 2;
	$mail->SMTPSecure = "tls";
	$mail->Host = MAILHOST; //Servidor de envio
	$mail->Port = MAILPORT; //Porta de envio
	$mail->Username = MAILUSER; //email para smtp autenticado
	$mail->Password = MAILPASS; //seleciona a porta de envio
	$mail->From = ($from); //remtente
	$mail->FromName = ($fromName); //remtetene nome
	if($reply){
		$mail->AddReplyTo(($reply),($replyName));	
	}
	$mail->Subject = ($subject); //assunto
	$mail->Body = ($message); //mensagem
	$mail->AddAddress(($to),($toName)); //email e nome do destino
	if($mail->Send()){
		return true;
	}
}
/***********************************
FUNÇÃO DATA TIMESTAMP
***********************************/
function formDate($date){
	$timestamp = explode(" ",$date);
	$getDate = $timestamp[0];
	$getTime = $timestamp[1];
	$getDate = explode('/',$getDate);
	if(!$getTime){
		$getTime = date('H:i:s');
	}
	$result = $getDate[2].'-'.$getDate[1].'-'.$getDate[0].' '.$getTime;
	return $result;
}
/***********************************
FUNÇÃO GERENCIAR ESTATISTICAS
***********************************/
function viewManager($time = 900){
	$month = date('m');
	$year = date('Y');
	delete('cuc_viewers_online', 'WHERE time_end<?', array(time()), 'i');
	if(empty($_SESSION['viewData']['session'])){
		$_SESSION['viewData']['session'] = session_id();
		$_SESSION['viewData']['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['viewData']['url'] = $_SERVER['PHP_SELF'];
		$_SESSION['viewData']['time_end'] = time()+$time;
		create('cuc_viewers_online', $_SESSION['viewData'], "sssi");
		if(!$readViews = read('cuc_views',"WHERE month=? AND year=?", array($month, $year), 'ii')){
			$data = array('month'=>$month, 'year'=>$year);
			create('cuc_views', $data, "ii");
		}else{
			foreach($readViews as $value);
			if(empty($_COOKIE['startView'])){
				$data = array('views' => $value['views']+1, 'viewers' => $value['viewers']+1);
				update('cuc_views', $data, 'WHERE month=? AND year=?', array($month, $year), "iiii");
				setcookie('startView', time(), strtotime(date('Y-m-d 23:59:59')));
			}else{
				$data = array('views' => $value['views']+1);
				update('cuc_views', $data, "WHERE month=? AND year=?", array($month, $year), "iii");				
			}
		}
	}else{
		if($readViews = read('cuc_views',"WHERE month=? AND year=?", array($month, $year), 'ii')){
			foreach($readViews as $value);
			$data = array('page_views' => $value['page_views']+1);
			update('cuc_views', $data, "WHERE month=? AND year=?", array($month, $year), "iii");
		}
		if($_SESSION['viewData']['time_end'] <= time()){
			delete('cuc_viewers_online', 'WHERE time_end<=?', array(time()), 'i');
			unset($_SESSION['viewData']);
		}else{
			$_SESSION['viewData']['time_end'] = time()+$time;
			$endTime = array('time_end' => $_SESSION['viewData']['time_end']);	
			update('cuc_viewers_online', $endTime, "WHERE session=?",array($_SESSION['viewData']['session']), "is");	
		}
	}
}
/***********************************
FUNÇÃO PAGINAR
***********************************/
function paginator($table, $cond = NULL, $params = NULL, $types = NULL, $max, $url, $pag, $width = NULL, $maxLinks = 4){
	$readPag = read($table, $cond, $params, $types);
	$totalData = count($readPag);
	if($totalData > $max){
		$totalPags = ceil($totalData/$max);
		if($width){
			echo '<div class="paginator" style="width:'.$width.'">';
		}else echo '<div class="paginator">';
		if($pag > $maxLinks+1) echo '<a href="'.$url.'1">Primeira</a> ';
		for($i = $pag-$maxLinks; $i <= $pag-1; $i++){
			if($i >= 1){
				echo '<a href="'.$url.$i.'">'.$i.'</a> ';
			}
		}
		echo '<span class="curentPag">'.$pag.'</span> ';
		for($i = $pag+1; $i <= $pag+$maxLinks; $i++){
			if($i <= $totalPags){
				echo '<a href="'.$url.$i.'">'.$i.'</a> ';
			}
		}
		if($pag+$maxLinks < $totalPags) echo '<a href="'.$url.$totalPags.'">Última</a>';
		echo '</div><!-- paginator -->';
	}
}
/***********************************
FUNÇÃO ENCRIPTAR SENHA
***********************************/
function encPswd($string) {
	$enc_string = base64_encode($string);
	$enc_string = str_replace("=","",$enc_string);
	$enc_string = strrev($enc_string);
	$md5 = md5($string);
	$enc_string = substr($md5,0,5).$enc_string.substr($md5,-5);
	return $enc_string;
}
/***********************************
FUNÇÃO UPAR IMAGENS
***********************************/
function uploadImage($tmp, $name, $width, $folder){
	if(preg_match('/\.(jpg|png|gif|jpeg)$/i', $name, $ext)){
		switch(strtolower($ext[1])){
			case 'jpg' : $img = imagecreatefromjpeg($tmp); break;
			case 'jpeg' : $img = imagecreatefromjpeg($tmp); break;
			case 'png' : $img = imagecreatefrompng($tmp); break;
			case 'gif' : $img = imagecreatefromgif($tmp); break;
		}
		$x = imagesx($img);
		$y = imagesy($img);
		$height = $width*$y/$x;
		$new = imagecreatetruecolor($width, $height);
		imagealphablending($new, false);
		imagesavealpha($new, true);
		$bool = imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $x, $y);
		if ($bool){
			switch(strtolower($ext[1])){
				case 'jpg' : 
					header("Content-Type: image/jpeg");
					imagejpeg($new, $folder.$name, 100);
					break;
				case 'jpeg' :
					header("Content-Type: image/jpeg");
					imagejpeg($new, $folder.$name, 100);
					break;
				case 'png' : 
					header("Content-Type: image/png");
					imagepng($new, $folder.$name);
					break;
				case 'gif' :
					header("Content-Type: image/gif");
					imagegif($new, $folder.$name);
					break;
			}
		}
		imagedestroy($img);
		imagedestroy($new);
	}
}
/***********************************
FUNÇÃO BUSCAR URL SEMELHANTE
***********************************/
function searchUrl($searcUrl){
	$limite = -1;
	$readPost = read('cuc_posts');
	foreach($readPost as $post){
		$lev = levenshtein($searcUrl, $post['url']);
		if ($lev <= $limite || $limite < 0){
			$saida_aux  = $post['url'];
			$limite = $lev;
		}
	}
	if($limite <= 5 && $limite != 0){
		$saida = $saida_aux;
	}
	return $saida;
}
?>