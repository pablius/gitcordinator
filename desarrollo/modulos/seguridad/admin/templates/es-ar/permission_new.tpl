<h1 align="center" class="titulo2">Agregar Permiso</h1>
{if $error}
	<div class="error">
		<ul><font class="error">Error en los datos:</font>
			{if $INVALID_NAME}<li>El Nombre del Permiso no es v&aacute;lido.</li>{/if}
			{if $INVALID_NICENAME}<li>La Descripci&oacute;n del Permiso no es v&aacute;lida.</li>{/if}
			{if $DUPLICATE_PERMISSION}<li>Nombre de Permiso duplicado.</li>{/if}

			{if $SENT_DUPLICATE_DATA}
				<li>Los datos de este fomulario ya han sido enviados para su procesamiento.</li>
			{/if}
			
		</ul>
	</div>	
{/if}

<form name="form1" method="post" action="">
	{$formElement}
	<table width="100%"  border="0" cellpadding="0" class="lista1">
		<tr>
			<td width="50%" height="30" align="right" class="texto1">M&oacute;dulo</td>
			<td>
				<select name="cboModulo"> 
					{html_options values=$arrIdModulo selected=$modSelect output=$arrModulo}
				</select>
			</td>
		</tr> 
		
		
		<tr>
			<td width="50%" height="30" align="right" class="texto1">Nombre</td>
			<td width="52%">
				<input type="text" name="txtName" value="{$newName}">
			</td>
		</tr> 
		
		
		<tr>
			<td width="50%" height="30" align="right" class="texto1">Descripci&oacute;n</td>
			<td>
				<input type="text" name="txtNiceName" value="{$newNiceName}">
				
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


