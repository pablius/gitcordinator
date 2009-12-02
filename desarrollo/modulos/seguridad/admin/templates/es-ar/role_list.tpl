<h1 align="center" class="titulo2">Lista de Roles</h1>
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
  
  
<form name="list" method="post" action="{$webdir}/seguridad/role/list">
{$formElement}
<table width="100%"  border="0">
  <tr>
    <td valign="top"> <font class="small">Esta es la lista de roles registrados en el sistema </font>          
  </tr>

  <tr>
    <td valign="top">
	 <br>

       				
       				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
                      <tr>
                        <td class="cuadro-arriba"><div align="left" ><a class="texto4" href="{$webdir}/seguridad/role/list/name"><strong>Nombre</strong></a></div></td>
                        <td class="cuadro-arriba"><div align="center" ><a class="texto4" href="{$webdir}/seguridad/role/list/description"><strong>Descripci&oacute;n</strong></a></div></td>
                        <td colspan="2" class="cuadro-arriba"><div align="right" class="texto4"><strong>Borrar</strong></div></td>
                      </tr>
                     {section name=r loop=$roles}
					  <tr class="{cycle values="lista1,lista2"}">
                        <td ><strong><a class="texto-boton" href="{$webdir}/seguridad/role/update/{$roles[r].id}">{$roles[r].name}</a></strong></td>
                        <td align="center" class="texto2" >{$roles[r].description}</td>
                        <td colspan="2" align="right" class="texto2" >
						{if $allowDelete}
							<input type="checkbox" name="selected_roles[]" value="{$roles[r].id}">
						{else}
							&nbsp;
						{/if}
						</td>
                      </tr>
					  {sectionelse}
					   <tr>
					       <td colspan="3" class="texto3"> No se encontraron roles. </td>
					   </tr>
					  {/section}
      </table>       				
<hr>
	{if $allowDelete}
          <div align="right">
			<a href="javascript:ChequearTodos('selected_roles[]','list',true)" class="boton1" >&lt;&lt;Seleccionar todo&gt;&gt;</a>				
			&nbsp;
			<a href="javascript:ChequearTodos('selected_roles[]','list',false)" class="boton2" >&lt;&lt;Deseleccionar&gt;&gt;</a>
			&nbsp;
            <input name="delete_submit" type="submit" value="Borrar Seleccionados">
        </div>
	{/if}
	{if $allowNew}
          <div align="left">
			<a href="{$webdir}/seguridad/role/new" class="texto-boton">Nuevo Rol &gt;&gt;</a>	  	 </div>
	<br>
	{/if}
    
  </tr>

</table>
<br>
<hr class="barra">
<div align="center">
  <input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
</div>
</form>