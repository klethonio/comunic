<?php
ob_start();
session_start();
require('../dts/dbaSis.php');
require('../dts/getSis.php');
require('../dts/setSis.php');
require('../dts/othSis.php');

if ($_SESSION['adUser']) {
    $readUser = read('cuc_users', 'WHERE id=?', array($_SESSION['adUser']['id']), 'i');
    if ($readUser) {
        $adUser = $readUser[0];
        $_SESSION['adUser']['level'] = $adUser['level'];
        if ($adUser['level'] != 1 && $adUser['level'] != 2) {
            header('Location: ' . BASE . '/pagina/perfil');
        } elseif ($adUser['pswd'] != $_SESSION['adUser']['pswd']) {
            unset($_SESSION['adUser']);
            setcookie('adUser', "", time() - 3600);
            header('Location: index.php');
        }
    } else {
        unset($_SESSION['adUser']);
        setcookie('adUser', "", time() - 3600);
        header('Location: ' . BASE . '/admin/index2.php');
    }
} else {
    header('Location: ' . BASE . '/admin');
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>Painel Administrativo - <?= SITENAME ?></title>

    <meta name="title" content="Painel Administrativo - <?= SITENAME ?>" />
    <meta name="description" content="Área restrita aos administradores do site <?= SITENAME ?>" />
    <meta name="keywords" content="Login, Recuperar Senha, <?= SITENAME ?>" />

    <meta name="author" content="Klethonio Ferreira" />   
    <meta name="url" content="<?= BASE ?>/admin/index2.php" />

    <meta name="language" content="pt-br" /> 
    <meta name="robots" content="NOINDEX,NOFOLLOW" />

    <link rel="icon" type="image/png" href="ico/chave.png" />
    <link rel="stylesheet" type="text/css" href="css/painel.css" />
    <link rel="stylesheet" type="text/css" href="css/geral.css" />
    <link rel="stylesheet" type="text/css" href="../js/shadowbox/shadowbox.css"/>
    <link href="plugins/fancyuploader/fancy-file-uploader/fancy_fileupload.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <div id="band"></div>
    <div id="painel">
            <?php require('includes/header.php'); ?>
        <div id="content">
                <?php require('includes/menu.php'); ?>
            <div class="pg">
                <?php
                if (!empty($_GET['url'])) {
                    $url = $_GET['url'];
                    $url = explode('/', $url);
                    $url[0] = !$url[0] ? 'home.php' : $url[0];
                    if (file_exists($url[0] . '.php')) {
                        require($url[0] . '.php');
                    } elseif (file_exists($url[0] . '/' . $url[1] . '.php')) {
                        require($url[0] . '/' . $url[1] . '.php');
                    } else {
                        echo '<span class="ms in">Página não encontrada!</span>';
                    }
                }else {
                    require('home.php');
                }
                ?>
            </div><!-- pg -->
        </div><!-- /content -->
        <div style="clear:both"></div> 
        <div id="footer">Desenvolvido por <a href="mailto:klethonio_@hotmail.com">Klethônio Ferreira</a></div> <!-- //footer -->
    </div><!-- //painel -->
</body>
<?php
require('../js/jscSis.php');
require('js/jsc.php');
ob_end_flush();
?>
</html>