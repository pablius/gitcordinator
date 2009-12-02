<?
global $ari;
$ari->t->force_compile =true;
$ari->t->cache = true;

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "setup_1.tpl");
 
?>