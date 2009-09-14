<div id="page-header">
	<div id="page-header-title">
		<h2>Project Settings</h2>
	
		
	</div>
	
	<div id="page-header-action">
		
	</div>
</div>

<div id="content-wrapper">

	
	<form action="" method="post" accept-charset="utf-8">
		<div class="field no-border">
			<div class="col span-2">
				<label for="name">Project Name</label>
			</div>
			<div class="col last span-3">
				<input type="text" name="name" value="{$name}" id="name" />
			</div>
		</div>
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="local">Use local repository</label>
			</div>
			<div class="col last span-3">
				<input type="checkbox" name="repo_local" value="1" {if $repo_local == 1}checked{/if} id="repo_local" />
			</div>
			<div class="col last span-3">
				Si el usuario no marca el check, acá tiene q salir un link para bajar los archivos para configurar su SVN local para que funcione con claris.
			</div>
		</div>
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="sprint_speed">Define sprint lenght</label>
			</div>
			<div class="col last span-3">
				<select id="sprint_speed" name="sprint_speed">
					{html_options options=$speed_array selected=$sprint_speed}
				</select>
			</div>
		</div>
		
		
		<div class="field">
			<div class="col last span-4 nudge-2">
						<input type="submit" name="store" value="Update data" id="store" />
			</div>
		</div>
		
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="backup">Download project backup</label>
			</div>
			<div class="col last span-4">
				<p> You can download a full copy of your project at Claris, just to be safe, or to play magic with it.</p>
				<a href='#'>download</a>
			</div>
			<div class="col last span-2">
				<label for="delete">Delete project</label>
			</div>
			<div class="col last span-4">
				<p> Deleting your project clears all data fromo our servers, including stories, people, and SVN. Of course this action can't be reversed, so be very careful.</p>
				<a href='#'>delete project</a>
			</div>
		</div>
		
	</form>
</div>
