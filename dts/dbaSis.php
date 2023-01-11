<?php
require('iniSis.php');

$pdo = new PDO('mysql:host='.HOST.';dbname='.DBSA, USER, PASS);

$setCharset = $pdo->query("SET NAMES 'utf8'");
$setCharset = $pdo->query("SET character_set_connection=utf8");
$setCharset = $pdo->query("SET character_set_client=utf8");
$setCharset = $pdo->query("SET character_set_results=utf8");

/***********************************
FUNÇÃO CADASTRAR
***********************************/
function create($table, $data, $types){
	global $pdo;
	$columns = implode(", ", array_keys($data));
	$values = str_repeat("?, ", count($data)-1)."?";
	$types = str_split($types);
	$stCreate = $pdo->prepare("INSERT INTO ".$table." (".$columns.") VALUES (".$values.")");
	$i = 1;
	foreach($data as $value){
		$stCreate->bindValue($i, $value, ($types[$i-1] == "s" ? PDO::PARAM_STR : ($types[$i-1] == "i" ? PDO::PARAM_INT : "false")));
		$i++;
	}
	if($stCreate->execute()){
		return true;
	}else{
            echo print_r($stCreate->errorInfo());
        }
}
/***********************************
FUNÇÃO LER
***********************************/
function read($table, $cond = NULL, $params = NULL, $types = NULL){
	global $pdo;
	$stRead = $pdo->prepare("SELECT * FROM ".$table." ".$cond);
	if($params){
		$i = 1;
		foreach($params as $value){
			$stRead->bindValue($i, $value, ($types[$i-1] == "s" ? PDO::PARAM_STR : ($types[$i-1] == "i" ? PDO::PARAM_INT : "false")));
			$i++;
		}
	}
	$stRead->execute();
	if($stRead->rowCount() > 0){
		return $stRead->fetchAll(PDO::FETCH_ASSOC);
	} else {
		return [];
	}
}
/***********************************
FUNÇÃO ATUALIZAR
***********************************/
function update($table, $data, $cond, $params, $types){
	global $pdo;
	$fields = implode('=?, ', array_keys($data)).'=?';
	$types = str_split($types);
	$stUpdate = $pdo->prepare("UPDATE ".$table." SET ".$fields." ".$cond);
	$i = 1;
	foreach($data as $value){
		$stUpdate->bindValue($i, $value, ($types[$i-1] == "s" ? PDO::PARAM_STR : ($types[$i-1] == "i" ? PDO::PARAM_INT : "false")));
		$i++;
	}
	if($params){
		foreach($params as $value){
			$stUpdate->bindValue($i, $value, ($types[$i-1] == "s" ? PDO::PARAM_STR : ($types[$i-1] == "i" ? PDO::PARAM_INT : "false")));
			$i++;
		}
	}
	if($stUpdate->execute()){
		return true;
	}
}
/***********************************
FUNÇÃO DELETAR
***********************************/
function delete($table, $cond, $params, $types){
	global $pdo;
	$types = str_split($types);
	$stDelete = $pdo->prepare("DELETE FROM ".$table." ".$cond);
	if($params){
		$i = 1;
		foreach($params as $value){
			$stDelete->bindValue($i, $value, ($types[$i-1] == "s" ? PDO::PARAM_STR : ($types[$i-1] == "i" ? PDO::PARAM_INT : "false")));
			$i++;
		}
	}
	if($stDelete->execute()){
		return true;
	}
}
?>