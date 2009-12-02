<h1 align="center" class="titulo2">Nuevo Rol</h1>
<form name="new" method="post" action="{$webdir}/seguridad/role/new">
{$formElement}
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
			 {if $INVALID_NAME}     
				<li>El Nombre del Rol no es v&aacute;lido.</li>
			 {/if}
			 {if $INVALID_DESCRIPTION}     
				<li>La Descripci&oacute;n del Rol no es v&aacute;lida.</li>
			 {/if}
			 {if $DUPLICATE_ROLE}     
				<li>Ya existe un Rol con el mismo Nombre.</li>
			 {/if}

			{if $SENT_DUPLICATE_DATA}
				<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
			{/if}
			 
         </ul>
  </div>
{/if}

<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
      <tr class="cuadro-arriba">
        <td colspan="2" class="texto4">Nombre</td>
      </tr>
      <tr>
        <td width="4%" height="29" class="cuadro-abajo">&nbsp;</td>
        <td width="96%" class="cuadro-abajo"><input name="name" type="text" value="{$new_name}"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" colspan="2"><br />
        <br />
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
            <tr class="cuadro-arriba">
              <td colspan="2" class="texto4">Descripci&oacute;n</td>
            </tr>
            <tr class="cuadro-abajo">
              <td width="4%" height="87">&nbsp;</td>
              <td width="96%"><textarea name="description" cols="50" rows="5">{$new_description}</textarea></td>
            </tr>
          </table>
        <br>
   	  </td>
 </tr>
 <tr>
	<td colspan="2">&nbsp;</td>
 </tr>
 <tr>
	<td class="lista1">
      <input name="anonymous_check" type="checkbox" value="1" {$checked_anonymous}>
      <span class="texto1">An&oacute;nimo </span></td>
	<td class="lista1">
      <input name="trustees_check" type="checkbox" value="1" {$checked_trustees}>
      <span class="texto4">Incluir en la lista de Confiados</span> </td>
 </tr>
</table>
<input name="id" type="hidden" value="{$id}">
<br>
<hr class="barra">
<div align="center">
  <input name="ok" type="submit" id="ok" value="Aceptar">
  <input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
</div>
</form>