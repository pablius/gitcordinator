<div id="inner-wrapper">
	<div id="page-header">
		<div class="col span-8">
			<h2>Dailiy Scrums</h2>
		</div>
		
		<div class="col last span-4">
		ACA VA UN SELECTOR PARA SPRINT y UNO PARA USUARIO
		</div>
	</div>
	
	<div id="content-wrapper">
		
		{section name=s loop=$ds_result}
		<div class="story">
					
			<div class="story-description">
				<div class="story-title">
					<small>Date: {$ds_result[s].date|relativedate}</small><br>
					<small>Person: <a href="{$webdir}/project/browse/person/{$ds_result[s].person}">@{$ds_result[s].person}</a></small><br>
					<small>Sprint: {$ds_result[s].sprint}</small><br>
					<small>Yesterday: {$ds_result[s].yesterday}</small><br>
					<small>Today: {$ds_result[s].today}</small><br>
					<small>Blocks: {$ds_result[s].blocks}</small>
				</div>
				
				
			</div>
		</div>
		{/section}
	
	</div>
</div>

	
	