<h1 align="center" class="titulo2">Agregar Acci&oacute;n</h1>
<script language="javascript" type="text/javascript" src="{$webdir}/scripts/functionsjs/action_function.js">
</script>
<font class="error" id="title_delete" style="visibility:hidden">Quitar</font>
	<form name="form1" method="post" action="">
    	{$formElement}
		<table width="100%" cellpadding="0" cellspacing="0">
			<tr>
			  <td height="54" colspan="2">
				{if $error} 
					  <ul><font color="#FF0000" class="error">Error en los datos:</font>
						{if $DUPLICATE_ACTION}
						  <li class="error"><font color="#FF0000" >Acci&oacute;n duplicada.</font></li>
						  {/if}
						{if $INVALID_ACTION}<li class="error"><font color="#FF0000" >Acci&oacute;n Inv&aacute;lida.</font></li>
						{/if}
						{if $NO_ACTION}<li class="error"><font color="#FF0000" >Debe agregar al menos una Acci&oacute;n.</font></li>
						{/if}
						{if $INVALID_NAME}<li class="error"><font color="#FF0000" >Nombre Inv&aacute;lido para una Acci&oacute;n. Revise las Acciones agregadas.</font></li>
						{/if}
						{if $INVALID_NICENAME}<li class="error"><font color="#FF0000" >Descripci&oacute;n Inv&aacute;lida. Revise las Descripciones para las Acciones agregadas.</font></li>
						{/if}
						{if $INVALID_PERMISSION}<li class="error"><font color="#FF0000" >Identificador de Permiso Inv&aacute;lido.</font></li>
						{/if}
						{if $INVALID_INMENU}<li class="error"><font color="#FF0000" >Datos Inv&aacute;lidos para valores de Men&uacute;.</font></li>
						{/if}
						{if $SENT_DUPLICATE_DATA}
							<li class="error">Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
						{/if}
						  
					  </ul>
				  {/if}
			 </td>
			</tr>
			<tr>
			  <td height="158" colspan="2" valign="top">
					{section name=m loop=$modules}
					<table width="100%" height="69" border="0" cellpadding="0" cellspacing="0" class="borde-caja">
                      <tr class="cuadro-arriba">
                        <td><span class="texto1">M&oacute;dulo:</span> {$modules[m].name}</td>
                      </tr>
                      <tr class="cuadro-abajo">
                        <td><span class="texto1">Pemiso:</span> 
						<select name="cboPerm{$modules[m].id}" id="cboPerm{$modules[m].id}">  
							{html_options output=$modules[m].permission_name values=$modules[m].permission_id}
						
					    </select>					
						<br>
						<span class="texto1">Nombre Acci&oacute;n:</span>
                        <input type="text" name="txtAccion{$modules[m].id}" value="{$newAccion}">
                        <span class="texto1">Descripci&oacute;n:</span>
                        <input type="text" name="txtNiceName{$modules[m].id}" value="{$newNiceName}">
						
						<input name="chkInMenu{$modules[m].id}" type="checkbox" value="">
						En Men&uacute;
						<a href="javascript:createAccion('{$modules[m].id}')" class="texto-boton">Agregar</a>						</td>
                      </tr>
                </table> </br>
					<table id="table{$modules[m].id}" >
							{section name=r loop=$modules[m].refrescados}
								<tr id="{$modules[m].refrescados[r].row}">
									<td style="visibility:hidden"><input name="modulo[]" value="{$modules[m].refrescados[r].modulo}" size="1"></td>
									<td style="visibility:hidden"><input name="permiso[]" value="{$modules[m].refrescados[r].permiso}" size="1"></td>
									<td style="visibility:hidden"><input name="accion[]" value="{$modules[m].refrescados[r].accion}" size="1"></td>
									<td style="visibility:hidden"><input name="nicename[]" value="{$modules[m].refrescados[r].nicename}" size="1"></td>
									<td style="visibility:hidden"><input name="inmenu[]" value="{$modules[m].refrescados[r].inmenu}" size="1"></td>
									<td class="texto2" style="visibility:hidden">{$modules[m].refrescados[r].modulo}</td>
									<td class="texto2">{$modules[m].refrescados[r].permisoName}</td>
									<td class="texto2">{$modules[m].refrescados[r].accion}</td>
									<td class="texto2">{$modules[m].refrescados[r].nicename}</td>
									<td class="texto2">{$modules[m].refrescados[r].inmenu}</td>
									<td><a href="javascript:removeRowTable('table{$modules[m].id}','{$modules[m].refrescados[r].row}')" class="error">Quitar</a></td>
								</tr>
							{/section}
				  </table>
					{/section}
					
			  </td>
			
			</tr>
			
			
			<tr>
				<td height="58" colspan="2">
					<div align="center">
						<input type="submit" name="guardar" value="Guardar" id="guardar2" >
						<input type="submit" name="cancelar" value="Cancelar" id="cancelar2" >
					</div>
				</td>
			</tr>	 

   	  </table>
		
		
	</form>
<script language="javascript" type="text/javascript" >setID('form1');</script>
