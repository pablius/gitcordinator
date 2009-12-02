<h1 align="center" class="titulo2">Actualizar Datos</h1>
<form name="login" method="post" action="{$webdir}/seguridad/user/update">
{$formElement}
  <table width="100%"  border="0">
  <tr>
    <td valign="top">
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
         {if $INVALID_USER}<li>El Usuario ya existe o es inv&aacute;lido</li> {/if}
		 {if $INVALID_PASS}<li>Contrase&ntilde;a inv&aacute;lida (4 a 8 caracteres alfanum&eacute;ricos)</li>{/if}
         {if $NO_CONCUERDAN}<li>Las contrase&ntilde;as no concuerdan</li>{/if}
  		 {if $INVALID_EMAIL}<li>Ha introducido una direcci&oacute;n de Correo Electr&oacute;nico inv&aacute;lida  </li>{/if}
		
		{if $SENT_DUPLICATE_DATA}
			<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
		{/if}
		 
         </ul>
       </div>
        <p>{/if}      </p>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr class="cuadro-arriba">
            <td colspan="2" class="texto1">Usuario </td>
          </tr>
          <tr class="cuadro-abajo">
            <td width="5%" height="29">&nbsp;</td>
            <td width="95%"><input name="user_name" type="text" value="{$uname}" readonly="true">
      </td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr class="cuadro-arriba">
            <td colspan="2" class="texto1">Contrase&ntilde;a</td>
          </tr>
          <tr class="cuadro-abajo">
            <td width="5%" height="46">&nbsp;</td>
            <td width="95%"><input name="user_pass" type="password" maxlength="8">
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
            <td width="5%">&nbsp;</td>
            <td width="95%"><input name="email" type="text" id="email" value="{$email}"> </td>
          </tr>
        </table>
        <br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
          <tr class="cuadro-arriba">
            <td colspan="2" class="texto1">Estado</td>
          </tr>
          <tr class="cuadro-abajo">
            <td width="5%" height="23">&nbsp;</td>
            <td width="95%"><select name="status_select">
	     	{html_options values=$status_values selected=$status output=$status_names}
		</select>  
</td>
          </tr>
        </table>
        <p align="center"><br>
          <input name="id" type="hidden" value="{$id}">
          <input name="update" type="submit" id="update" value="Actualizar">
          <input name="BackButton" type="button" value="Volver" onClick="history.back()"> 
        </p>
      </td>
  </tr>
</table>

</form>