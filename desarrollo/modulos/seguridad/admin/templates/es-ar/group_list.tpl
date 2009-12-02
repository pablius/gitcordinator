<h1 align="center" class="titulo2">Lista de Grupos de Usuarios </h1>
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

  
<form name="list" method="post" action="{$webdir}/seguridad/group/list">
{$formElement}
<table width="100%"  border="0">
  <tr>
    <td valign="top"> <font class="small">Esta es la lista de grupos de usuarios registrados en el sistema </font>          
  </tr>

  <tr>
    <td valign="top">
	 <br>

       				
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
			  <tr class="cuadro-arriba">
				<td><div align="left" ><a class="texto4" href="{$webdir}/seguridad/group/list/name"><strong>Nombre</strong></a></div></td>
				<td><div align="center" ><a class="texto4" href="{$webdir}/seguridad/group/list/description"><strong>Descripci&oacute;n</strong></a></div></td>
				<td colspan="2"><div align="right" class="texto4"><strong>Borrar</strong></div></td>
		  </tr>
			 {section name=g loop=$groups}
			     <tr class="lista1"lista1,lista2"}">
				<td ><strong><a href="{$webdir}/seguridad/group/update/{$groups[g].id}" class="texto-boton">{$groups[g].name}</a></strong></td>
				<td align="center" class="texto2" >{$groups[g].description}</td>
				<td colspan="2" align="right" class="texto2">
				{if $allowDelete}
					<input type="checkbox" name="selected_groups[]" value="{$groups[g].id}">
				{else}
					&nbsp;
				{/if}
				</td>
		  </tr>
			  {sectionelse}
			   <tr class="cuadro-abajo">
				   <td colspan="3" class="error"> No se encontraron grupos de usuarios. </td>
	      </tr>
			  {/section}
      </table>       				
<hr>
	{if $allowDelete}
          <div align="right">
			<a href="javascript:ChequearTodos('selected_groups[]','list',true)" class="boton2" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
			&nbsp;
			<a href="javascript:ChequearTodos('selected_groups[]','list',false)" class="boton1" >&lt;&lt;Deseleccionar&gt;&gt;</a>
			&nbsp;
            <input name="delete_submit" type="submit" value="Borrar Seleccionados">
        </div>
     {/if}
	{if $allowNew}
          <div align="left">
			<a href="{$webdir}/seguridad/group/new" class="texto-boton">Nuevo Grupo de Usuarios &gt;&gt;</a>	  	 </div>
	<br>
	{/if}
<hr>
  </tr>

</table>
<br>
<hr class="barra">
<input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
</form>