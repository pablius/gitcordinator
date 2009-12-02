<h1 align="center" class="titulo2">Nuevo  Grupo de Usuarios</h1>
<form name="new" method="post" action="{$webdir}/seguridad/group/new">
{$formElement}


  <table width="100%"  border="0">
  <tr>
    <td height="355" valign="top">
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
         {if $INVALID_NAME}<li>Debe ingresar un nombre para el grupo de usuarios v&aacute;lido.</li>
         {/if}
		 {if $INVALID_DESCRIPTION}<li>La descripci&oacute;n para el grupo de usuarios no es v&aacute;lida.</li>
		 {/if}
		 {if $DUPLICATE_GROUP}<li>Ya existe un grupo de usuarios con el mismo nombre.</li>{/if}

		{if $SENT_DUPLICATE_DATA}
			<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
		{/if}  
		      
		 </ul>
       </div>
        <p>{/if}      </p>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr>
            <td colspan="2" class="cuadro-arriba"><span class="texto1">Nombre</span></td>
          </tr>
          <tr>
            <td width="4%" height="28" class="cuadro-abajo">&nbsp;</td>
            <td width="96%" class="cuadro-abajo"><input name="name" type="text" value="{$new_name}" size="50">
      </td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr>
            <td colspan="2" class="cuadro-arriba"><span class="texto1">Descripci&oacute;n</span> </td>
          </tr>
          <tr>
            <td width="4%" height="83" class="cuadro-abajo">&nbsp;</td>
            <td width="96%" valign="middle" class="cuadro-abajo"><textarea name="description" cols="50" rows="5">{$new_description}</textarea></td>
          </tr>
        </table>
        <p><div align="center">
  <input name="id" type="hidden" value="{$id}">
  <input name="ok" type="submit" id="ok" value="Aceptar">
    <input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
</div></p></td>
  </tr>
</table>

</form>