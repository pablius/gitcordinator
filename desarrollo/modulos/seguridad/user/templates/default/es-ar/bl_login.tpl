
{if $logued} 

	<div id="logged_in_box">
		Bienvenido <span>{$uname}</span> (<a href="{$webdir}/seguridad/logout">salir</a> | <a href="{$webdir}/seguridad/update">actualizar datos</a>)
	</div>

{else}

	<form name="login" method="post" action="{$webdir}/seguridad/login">
		<div id="login_box">
			<ul>
				<li>
					<a href="/seguridad/nuevo"><img src="{$webdir}/images/log.jpg" width="20" height="20" border="0" alt="Nuevo Usuario" />
				</li>

				<li>
					<a href="/seguridad/forgot"><img src="{$webdir}/images/forgot.jpg" width="20" height="20" border="0" alt="Recuperar Contrase&ntilde;a" /></a>	
				</li>

				<li>
					<input name="login" id="login" class="button" type="submit" value="Ingresar" alt="Ingresar" tabindex="3 "/>
				</li>

				<li class="table_sep"></li>

				<li>
					<input name="pass" class="input_text" type="password" id="pass" size="15" value="" alt="Contraseña" tabindex="2" />
				</li>

				<li class="table_sep"></li>

				<li>
					<span>Contrase&ntilde;a</span>&nbsp;
				</li>

				<li class="table_sep"></li>

				<li>
					<input name="uname" class="input_text" type="text" id="uname" size="15" value="" alt="Usuario" tabindex="1" />
				</li>

				<li class="table_sep"></li>

				<li>
					<span>Usuario</span>&nbsp;
				</li>
			</ul>
		</div>

		<div class="clear_box"></div>
	</form>
{/if}