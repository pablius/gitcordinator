{section name=u loop=$unplaned}
	<div class="story clearfix" title="Drag this story"  id="story_{$unplaned[u].number}">
		<div class="story-expand">
			<ul>
				<li><a href="" class="icon-arrow {$unplaned[u].text_class}" title="Edit this story">Edit</a></li>
			</ul>
		</div>
		
		<div class="story-description">
			<h4 class="{$unplaned[u].text_class}">{$unplaned[u].name}</h4>
			
			<ul>
				<li>
				<a href="/project/browse/person/{$unplaned[u].asigned}" title="View stories for {$unplaned[u].asigned}">@{$unplaned[u].asigned}</a> 
				{section name=ut loop=$unplaned[u].tags}
					<a href="/project/browse/tag/{$unplaned[u].tags[ut]}" title="View stories tagged as '{$unplaned[u].tags[ut]}'">#{$unplaned[u].tags[ut]}</a> 
				{/section}
				</li>
			</ul>
		</div>
	</div>
{/section}

