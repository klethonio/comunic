<?php
// You need to trim the slashs
define('BASE', 'http://localhost');
define('SITENAME', 'Comunic Notícias');
define('SITEDESC', 'Fique por dentro das últimas notícias na nossa região e no mundo no Comunic Notícias!');
define('SITETAGS', 'noticias, entretenimento, saúde, educação, segurança, coremas, paraiba, eventos');

// MySQL
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBSA', 'comunic');

// Mail
define('MAILNAME', '');
define('MAILUSER', '');
define('MAILPASS', '');
define('MAILPORT', '');
define('MAILHOST', '');

// Filemanager
/*
| path from base_url to base of project ie. for http://localhost/blog/ type /blog/

| if it is based on root, leave a /

| !!! with start and final /
*/
define('FILEMANAGER_DIR', '/');

// Address
define('ADDRESS', 'Address');
define('TEL', '(83) 6666-6666');
define('CEL', '(83) 9999-9999');

error_reporting(E_ALL ^ E_DEPRECATED);
