<?php

/* * *********************************
  FUNÇÃO INCLUIR ARQUIVOS
 * ********************************* */

function setArq($name) {
    if (file_exists($name . '.php')) {
        include($name . '.php');
    } else {
        echo 'Erro ao incluir <strong>' . $name . '.php</strong>, arquivo ou caminho não conferem!';
    }
}

/* * *********************************
  FUNÇÃO URL AMIGAVEL
 * ********************************* */

function setUrl($string) {
    $table = array(
        'Š' => 'S', 'š' => 's', '�?' => 'Dj', 'đ' => 'dj', 'Ž' => 'Z',
        'ž' => 'z', 'Č' => 'C', '�?' => 'c', 'Ć' => 'C', 'ć' => 'c',
        'À' => 'A', '�?' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
        'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', '�?' => 'I', 'Î' => 'I',
        '�?' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
        'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', '�?' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
        'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
        'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
        'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
        'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
        'ÿ' => 'y', 'Ŕ' => 'R', 'ŕ' => 'r'
    );
    $string = strtr($string, $table);
    $string = strtolower($string);
    $string = trim($string);
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    $string = preg_replace("/[\s-]+/", "-", $string);
    return $string;
}

/* * *********************************
  FUNÇÃO SOMAR VISITAS
 * ********************************* */

function setViews($id) {
    $readArticle = read('cuc_posts', "WHERE id=?", array($id), 'i');
    $article = $readArticle[0];
    $views = $article['views'];
    $views = $views + 1;
    $dateViews = array(
        'views' => $views
    );
    update('cuc_posts', $dateViews, 'WHERE id=?', array($id), 'ii');
}

?>