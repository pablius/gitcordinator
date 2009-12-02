<h1 align="center" class="titulo2">Lista de Usuarios</h1>
<script language="javascript" type="text/javascript" src="{$webdir}/scripts/functionsjs/functionsjs.js">
</script>

{if $error}
	<div class='error'>
		ERROR:
		<ul>
			{if $SENT_DUPLICATE_DATA}
				<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
			{/if}
		</ul> 
	</div>
{/if}

<form name="kind" method="post" action="{$webdir}/seguridad/user/list">
  <table width="100%"  border="0">
    <tr>
      <td valign="top" align="left">
		  <span class="texto1">Ingrese ID, nombre o email de usuario:</span>
		  <input name="text" id="text" value="{$text}" type="text">
		  <input name="search" id="search" type="submit" value="Buscar">
	  </td>
      <td valign="top" align="right">
		  <span class="texto1">Estado:</span>
		  <select name="kind_select">
			 {html_options values=$kind_values selected=$method output=$kind_names}
		  </select>
		  <input name="kind_order" type="hidden" value="{$order}">
		  <input name="kind_submit" type="submit" value="Ver">
	  </td>
    </tr>
  </table>
</form>  

<table width="100%"  border="0">
  <tr>
    <td valign="top"> <font class="small">Esta es la lista de usuarios registrados en el sistema </font>          
	</td>
 </tr>
 
  <tr>
    <td valign="top">
	 <span class="boton1"><br>
Estas viendo los usuarios con estado: {$method}     </span><br>  
<br>  <br>
<form name="change" method="post" action="{$webdir}/seguridad/user/list">
	{$formElement}
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
	  <tr class="cuadro-arriba">
		<td><div align="left" ><a class="texto1" href="{$webdir}/seguridad/user/list/{$method}/uname{if $text}/{$text}{/if}"><strong>Login</strong></a></div></td>
		<td><div align="center" ><a class="texto1" href="{$webdir}/seguridad/user/list/{$method}/email{if $text}/{$text}{/if}"><strong>Correo Electr&oacute;nico</strong></a></div></td>
		<td><div align="right" ><a class="texto1" href="{$webdir}/seguridad/user/list/{$method}/status{if $text}/{$text}{/if}"><strong>Estado</strong></a></div></td>
	  <td width="10"></td>
	  </tr>
	 {section name=u loop=$usuarios}
	  <tr class="{cycle values="lista1,lista2"}">
		<td><strong><a href="{$webdir}/seguridad/user/update/{$usuarios[u].id}" class="texto-boton">{$usuarios[u].uname}</a></strong></td>
		<td align="center" class="texto2" >{$usuarios[u].email}</td>
		<td align="right" class="texto2" >{$usuarios[u].status}</td>
		<td class="texto2">
		{if $allowUpdate}
			<input type="checkbox" name="selected_users[]" value="{$usuarios[u].id}">
		{else}
			&nbsp;
		{/if}		</td>
	  </tr>
	  {sectionelse}
	   <tr><td colspan="3"> No se encontraron usuarios. </td>
	   </tr>
	  {/section}
	    </table>
		  <hr>       				
	<div align="center">{pager rowcount=$total limit=$limit txt_first="" class_num="small" class_numon="error" class_text="fl" show='page' txt_prev='anterior' txt_next='siguiente'}</div>
	{if $allowUpdate}
	<hr>
			  <div align="right">
				<a href="javascript:ChequearTodos('selected_users[]','change',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
				&nbsp;
				<a href="javascript:ChequearTodos('selected_users[]','change',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a>
				<br><br>
				<span class="texto2">&nbsp;
			  Modificar el estado de los seleccionados:</span>
				<select name="change_select">
					 {html_options values=$change_values output=$change_values}
				</select>
				<input name="select_submit" type="submit" value="Actualizar">
				<input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
	    </div>
	{/if}
</form>
<hr> 
 
  </td>
  </tr>

</table>

