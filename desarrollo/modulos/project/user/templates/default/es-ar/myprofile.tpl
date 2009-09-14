<div id="page-header">
	<div id="page-header-title">
		<h2>My Profile</h2>
	
		
	</div>
	
	<div id="page-header-action">
		
	</div>
</div>

<div id="content-wrapper">

	
	<form action="" method="post" accept-charset="utf-8">
		<div class="field no-border">
			<div class="col span-2">
				<label for="name">Nick-name</label>
			</div>
			<div class="col last span-3">
				<input type="text" name="name" value="{$name}" id="name" />
			</div>
			<div class="col last span-3">
				<p>We recomend using your twitter username here. Also, we'll grab your avatar from twitter if you do so.</p>
			</div>
		</div>
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="email">E-Mail</label>
			</div>
			<div class="col last span-3">
				<input type="text" name="email" value="{$email}" id="email" />
			</div>
		</div>
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="password">Password</label>
			</div>
			<div class="col last span-3">
				<input type="password" name="password" value="" id="password" autocomplete="off" />
			</div>
			<div class="col span-1">
				<label for="repeat">Repeat</label>
			</div>
			<div class="col last span-3">
				<input type="password" name="repeat" value="" id="repeat"  autocomplete="off"/>
			</div>
		</div>
		
		
		<div class="field">
			<div class="col last span-4 nudge-2">
						<input type="submit" name="store" value="Update data" id="store" />
			</div>
		</div>
		
	</form>
</div>
