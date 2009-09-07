<?
global $ari;
$ari->t->caching = false;
$ari->t->force_compile = true;

$ari->t->assign('people',project_person::project_tag_cloud($project));
$ari->t->assign('tags',project_tag::project_tag_cloud($project));

$ari->t->display($ari->module->usertpldir(). DIRECTORY_SEPARATOR . "browse.tpl");
 
?>