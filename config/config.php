<?php

error_reporting(E_ALL ^ E_NOTICE);
define("APP_NAME","Sales4U");
define('DS', DIRECTORY_SEPARATOR);
// define('DS', '/');
define('DEFAULT_CONTROLLER', 'Index');
//define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS .APP_NAME.DS);
//define('ROOT', $_SERVER['DOCUMENT_ROOT'] . DS );
define('DEFAULT_LAYOUT', 'default');
$root=$_SERVER['DOCUMENT_ROOT'] . DS .APP_NAME.DS;
$base='http://' . $_SERVER['SERVER_NAME'].'/'.APP_NAME.'/' ;
if("sales4u.fusioncolombiaesp.com"==$_SERVER['SERVER_NAME']){
    $root=$_SERVER['DOCUMENT_ROOT'] . DS ;
    $base='http://' . $_SERVER['SERVER_NAME'].'/' ;
}
define('BASE',$base);
define('ROOT',$root);

 

//define('BASE', 'http://' . $_SERVER['SERVER_NAME'].'/'.APP_NAME.'/' );
//define('BASE', 'http://' . $_SERVER['SERVER_NAME'].'/');
define("ROL_ADMINISTRADOR", "1");

define("DB_ROUTE","mysql:host=fusioncolombiaesp.com;dbname=sales4udb");
//define("DB_ROUTE","mysql:host=localhost;dbname=sales4udb");
//define("DB_USER","root"); 
define("DB_USER","sales4udb_u"); 
//define("DB_PASSWORD","1234");
define("DB_PASSWORD","-=HE46Z%?]fT");

define("CREATORS","2017");
define("POSTSUFIX","post_");
//die('Hola11');
// define("DB_USER","root"); 
// define("DB_PASSWORD","root");  