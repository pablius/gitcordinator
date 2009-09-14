<?
global $ari;

if ($ari->user->id() !=3)
{
	echo 'access restricted, only pablius can do this!';
} 

$ari->db->Execute ("TRUNCATE TABLE `project_person`");
$ari->db->Execute ("TRUNCATE TABLE `project_project`");
$ari->db->Execute ("TRUNCATE TABLE `project_sprint`");
$ari->db->Execute ("TRUNCATE TABLE `project_story`");
$ari->db->Execute ("TRUNCATE TABLE `project_tag`");
$ari->db->Execute ("TRUNCATE TABLE `project_daily`");
$ari->db->Execute ("TRUNCATE TABLE `sessions`");
$ari->db->Execute ("TRUNCATE TABLE `oob_user_online`");
$ari->db->Execute ("TRUNCATE TABLE `security_usersgroup`");
$ari->db->Execute ("DELETE FROM `oob_user_user` WHERE ID > 4");

 
?>