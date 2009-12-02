<h1 align="center" class="titulo2">Nuevo Usuario</h1>
<table width="100%"  border="0">
  <tr>

	<td valign="top"><span class="texto1">Ingrese los datos del nuevo usuario a continuaci&oacute;n: </span>
	  <form name="login" method="post" action="{$webdir}/seguridad/user/new">
		{$formElement}
		
		{if $error}
		   <div class="error">
			 <ul><font class="error">Error:</font>
				 {if $INVALID_USER}<li>El Usuario ya existe o es inv&aacute;lido</li> {/if}
				 {if $INVALID_PASS}<li>Contrase&ntilde;a inv&aacute;lida (4 a 8 caracteres alfanum&eacute;ricos)</li>{/if}
				 {if $NO_CONCUERDAN}<li>Las contrase&ntilde;as no concuerdan</li>{/if}
				 {if $INVALID_EMAIL}<li>Ha introducido una direcci&oacute;n de Correo Electr&oacute;nico inv&aacute;lida  </li>{/if}
				 {if $SENT_DUPLICATE_DATA}<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>{/if}
			 </ul>
		   </div>
			<p>{/if}		  </p>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
              <tr class="cuadro-arriba">
                <td colspan="2" class="texto1">Usuario </td>
              </tr>
              <tr class="cuadro-abajo">
                <td width="4%" height="30">&nbsp;</td>
                <td width="96%"><input name="newname" type="text" value="{$newname}">
		  </td>
              </tr>
            </table>
			<br />
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
              <tr class="cuadro-arriba">
                <td colspan="2" class="texto1">Contrase&ntilde;a</td>
              </tr>
              <tr>
                <td width="4%" height="42" class="cuadro-abajo">&nbsp;</td>
                <td width="96%" class="cuadro-abajo"><input name="password" type="password" maxlength="8">
            <input name="passtwo" type="password" maxlength="8">
</h2>
<br />
	    <font class="small">(debe ingresar la contrase&ntilde;a dos veces, para validarla)</font></td>
              </tr>
            </table>
			<br />
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
              <tr class="cuadro-arriba">
                <td colspan="2" class="texto1">Correo Electr&oacute;nico</td>
              </tr>
              <tr class="cuadro-abajo">
                <td width="4%" height="33">&nbsp;</td>
                <td width="96%"><input name="newemail" type="text" value="{$newemail}">
</td>
              </tr>
            </table>
			<p align="center">
			  <input name="register" type="submit" value="Registrarse">
	          <input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
	  </p>
      </form>    </td>

  </tr>
</table>


