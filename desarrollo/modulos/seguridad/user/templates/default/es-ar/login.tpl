<h2>Sign in</h2>
			
<form method="post" action="/seguridad/login">

	{if $error}
	<div class="field no-border">
		Invalid username or password.
	</div>
	{/if}

	<div class="field no-border">
		<div class="col span-2">
			<label for="username">Username</label>
		</div>
		<div class="col last span-3">
			<input type="text" name="uname" value="" id="username" />
		</div>
	</div>
	
	<div class="field no-border">
		<div class="col span-2">
			<label for="password">Password</label>
		</div>
		<div class="col last span-3">
			<input type="password" name="pass" id="password" />
		</div>
	</div>
	
	<div class="field">
		<div class="col last span-4 nudge-2">
			<input name="login" type="submit" id="login" class="button" value="Sign-in">
		</div>
	</div>
</form>