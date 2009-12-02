<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript" src="{$webdir}/scripts/functionsjs/user_functions.js"></script>

</head>
<body>

<div align="right">
	<a href="javascript:window.close()">Cerrar</a>
</div>

<form name="select" method="post" action="{$webdir}/seguridad/user/selectforemployee" enctype="multipart/form-data" >
<br>
Resultados de la b&uacute;squeda:
<table width="100%">
{section name=u loop=$users}
	<tr>
		<td>
			<a href="javascript:selectForEmployee('{$users[u].id}','{$users[u].unameClean}','{$users[u].email}' )">{$users[u].uname}</a>
		</td>
	</tr>
{sectionelse}
	<tr>
		<td>
			No se encontraron usuarios sin asignaci&oacute;n.
		</td>
	</tr>
{/section}
</table>

<br>
<div align="center">
	{pager rowcount=$total limit=$limit txt_first="" class_num="small" class_numon="error" class_text="fl" show='page' txt_prev='anterior' txt_next='siguiente'}
</div>


<br>
<hr class="barra">
<input name="BackButton" type="button" value="Cerrar" onClick="window.close()"> 
</form>

</body>
</html>