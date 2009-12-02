<h1 align="center" class="titulo2">Actualizar Datos</h1>
<form name="login" method="post" action="{$webdir}/seguridad/user/update">
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
         {if $INVALID_PASS}     <li>Contrase&ntilde;a inv&aacute;lida (4 a 8 caracteres alfanum&eacute;ricos)</li>{/if}
         {if $NO_CONCUERDAN}      <li>Las contrase&ntilde;as no concuerdan</li>{/if}
  		 {if $INVALID_EMAIL}            <li>Ha introducido una direcci&oacute;n de Correo Electr&oacute;nico inv&aacute;lida  </li>{/if}
         </ul>
       </div>
        {/if}

	  <h2>Usuario <br>
          <input name="uname" type="text" id="uname" value="{$uname}" readonly="true">
      </h2>
      <h2> Contrase&ntilde;a<br>

          <input name="pass" type="password" id="pass" maxlength="8">
          <input name="passtwo" type="password" id="passtwo" maxlength="8">
</h2>
<font class="small">(debe ingresar la contrase&ntilde;a dos veces, para validarla)</font>
<h2>Correo Electr&oacute;nico<br>
<input name="email" type="text" id="email" value="{$email}"> 
</h2>
<h2>Estado<br> 

       <select name="status_select">
              
            
	     {html_options values=$status_values selected=$status output=$status_names}
        
          
            </select>  </h2><br>
      <input name="id" type="hidden" value="{$id}">
      <input name="update" type="submit" id="update" value="Actualizar"></td>
  </tr>
</table>

</form>