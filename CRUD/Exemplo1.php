<?php

include_once("config.php");

$crud = new crud("TABELA", $con);
$crud->insert("campo1, campo2", "'valor1','valor2'");
//$crud->del();

echo "<pre>";
var_dump($pref);
echo "<br>";
echo "<br>";
var_dump($con);

echo "<a href='Exemplo2.php'>Exemplo 2</a>";

?>