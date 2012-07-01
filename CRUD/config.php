<?php
include_once("Preferences.php");
include_once("Conexao.php");
include_once ("CRUD.php");

$pref = Preferences::getInstance();

if(!$pref->getProperty("banco")) {
    $pref->setProperty("dns", "mysql:host=localhost;port=3306;dbname=DBNAME;charset_set_connection=utf-8;charset_set_client=utf-8;charset_set_results=utf-8");
    $pref->setProperty("usuario", "USUARIO");
    $pref->setProperty("senha", "SENHA");
    $pref->setProperty("banco", true);
}

$con = Conexao::getInstance($pref);
?>