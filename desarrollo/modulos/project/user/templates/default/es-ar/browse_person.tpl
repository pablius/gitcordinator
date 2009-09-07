<div id="inner-wrapper">
	<div id="page-header">
		<div class="col span-8">
			<h2>Stories for @{$name}</h2>
		</div>
		
		<div class="col last span-4">
		</div>
	</div>
	
	<div id="content-wrapper">
		{section name=s loop=$stories}
		<div class="story">
			<div class="story-sprint">
				<span>{$stories[s].sprint}</span>
			</div>
			
			<div class="story-status">
				<span class="{$stories[s].state_class}">{$stories[s].state}</span>
			</div>
			<div class="story-meta">
				<ul>
					<li class="number"><a href="single-story.html">{$stories[s].id}</a></li>
				</ul>
			</div>
			
			<div class="story-description">
				<div class="story-title">
					<h4 class="medium"><span class="editable" title="Click to edit">{$stories[s].name}</span></h4>
				</div>
				
				<div class="story-details">
					<ul>
						<li>
							<p>
								<a href="/project/browse/person/{$stories[s].asigned}" title="View stories for @{$stories[s].asigned}">@{$stories[s].asigned}</a>
								{section name=t loop=$stories[s].tags}
									<a href="/project/browse/tag/{$stories[s].tags[t]}" title="View stories tagged as '{$stories[s].tags[t]}'">#{$stories[s].tags[t]}</a> 
								{/section}
								<a href="" class="quick-edit" title="Click to edit persons and tags for this story">quick edit</a>
							</p>
						</li>
					</ul>
				</div>
				
			</div>
		</div>
		{/section}
	
	</div>
</div>

	
	