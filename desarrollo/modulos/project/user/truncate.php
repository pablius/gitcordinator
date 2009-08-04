<?
global $ari;

$ari->db->Execute ("TRUNCATE TABLE `project_person`");
$ari->db->Execute ("TRUNCATE TABLE `project_project`");
$ari->db->Execute ("TRUNCATE TABLE `project_sprint`");
$ari->db->Execute ("TRUNCATE TABLE `project_story`");
$ari->db->Execute ("TRUNCATE TABLE `project_tag`");

 
?>