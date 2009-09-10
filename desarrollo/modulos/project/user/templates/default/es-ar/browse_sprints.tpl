<div id="inner-wrapper">
	<div id="page-header">
		<div class="col span-8">
			<h2>Previous Sprints</h2>
		</div>
		
		<div class="col last span-4">
		</div>
	</div>
	
	<div id="content-wrapper">
		
		{section name=s loop=$sprints}
		<div class="story">
			<div class="story-sprint">
				<a href="{$webdir}/project/browse/sprint/{$sprints[s].number}"><span>{$sprints[s].number}</span></a>
			</div>
			
			
			<div class="story-description">
				<div class="story-title">
					<h4 class="medium"><span class="editable" title="Click to edit">{$sprints[s].goal}</span></h4>
					<br><br>
					{if $sprints[s].result != ''}<small>Eval meeting result: {$sprints[s].result}</small><br/>{/if}
					<small>Sprint total estimate: {$sprints[s].total_estimate}</small><br>
					<small>Started: {$sprints[s].started|relativedate}</small><br>
					<small>{$sprints[s].finished_string}: {$sprints[s].finished|relativedate}</small>
				</div>
				
				
			</div>
		</div>
		{/section}
	
	</div>
</div>

	
	