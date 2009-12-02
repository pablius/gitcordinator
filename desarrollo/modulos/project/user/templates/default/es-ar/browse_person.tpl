<div id="inner-wrapper" class="clearfix">
	<div id="page-header" class="clearfix">
		<div id="page-header-title">
			<h2>Stories for @{$name}</h2>
		</div>
	</div>
	
	<div id="content-wrapper" class="clearfix">
		<div class="col last span-12">
			<div class="stories-header clearfix">
				<ul>
					<li class="sprint"><strong>Sprint</strong></li>
					<li class="status"><strong>Status</strong></li>
					<li><strong>Story</strong></li>
				</ul>
			</div>
			{section name=s loop=$stories}
			<div class="story no-draggeable clearfix">
				<div class="story-sprint">
					<span>{$stories[s].sprint}</span>
				</div>
				
				<div class="story-status">
					<ul>
						<li><a href="#" class="{$stories[s].state_class}">{$stories[s].state}</a></li>
					</ul>
				</div>
				
				<div class="story-description">
					<h4 class="{$stories[s].text_class}"><span class="number" title="Story {$stories[s].number}">{$stories[s].number}</span>
					<a href="{$webdir}/project/story/view/{$stories[s].number}">{$stories[s].name}</a></h4>
					
					<ul>
						<li>
							<a href="/project/browse/person/{$stories[s].asigned}" title="View stories for @{$stories[s].asigned}">@{$stories[s].asigned}</a>
							{section name=t loop=$stories[s].tags}
								<a href="/project/browse/tag/{$stories[s].tags[t]}" title="View stories tagged as '{$stories[s].tags[t]}'">#{$stories[s].tags[t]}</a> 
							{/section}
						</li>
					</ul>
				</div>
			</div>
			{/section}
		
		</div>			
	</div>

</div>

	
	