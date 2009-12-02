{literal}
	<script type="text/javascript">
	$(function() {
		
		
		
		 $(document).ready(function() 
		{
			
			$("#download_project").bind('click', pending);
			$("#delete_project").bind('click', pending);

			
		});
		
	});
	</script>

{/literal}


<div id="inner-wrapper" class="clearfix">
	<div id="page-header" class="clearfix">
		<div id="page-header-title">
			<h2>Project Settings</h2>
		</div>
	</div>

	<div id="content-wrapper" class="clearfix">

		
		<form action="" method="post" accept-charset="utf-8">
		
			<div class="col span-8">
				<table class="project-settings">
					<tr>
						<th><label for="length">Sprint length</label></th>
						<td>
							<select id="sprint_speed" name="sprint_speed">
								{html_options options=$speed_array selected=$sprint_speed}
							</select>
						</td>
					</tr>
					<tr>
						<th><label for="">Use local repository</label></th>
						<td>
							<input type="checkbox" name="repo_local" value="1" {if $repo_local == 1}checked{/if} id="repo_local" />
						</td>
					</tr>
					<tr>
						<th />
						<td>
							<ul class="form-actions">
								<li><input type="submit" name="store" value="Save" id="store" /></li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
			
		</form>
		
		<div class="col last span-4">
			<div class="section clearfix">
				<div class="section-header clearfix">
					<div class="section-header-meta clearfix">
						<h3>Project Backup</h3>
					</div>
				</div>
				
				<div class="section-content">
					<p>You can download a full copy of your project at Claris, just to be safe, or to play magic with it.</p>
					<a href='#' id="download_project" class="mini-button">Download</a>
				</div>
			</div>
			<!--
			<div class="section clearfix">
				<div class="section-header clearfix">
					<div class="section-header-meta clearfix">
						<h3>Delete project</h3>
					</div>
				</div>
				
				<div class="section-content">
					<p>Deleting your project clears all data from our servers, including stories, people, and SVN. Of course this action can't be reversed, so be very careful.</p>
					<a href='#' id="delete_project" class="mini-button">Delete all</a>
				</div>
			</div>
			-->
		</div>
		
			
	</div>
		
</div>
