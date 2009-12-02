<div class="story-expand">
	<ul>
		<li><a href="#" class="icon-arrow {$text_class}" id="edit_{$number}" title="Edit this story">Edit</a></li>
	</ul>
</div>

<div class="story-description">
	<h4 class="{$text_class}">
		<span class="number" title="Story ID">{$number}</span>
		<a href="/project/story/view/{$number}" title="View source for this story">{$name}</a>
	</h4>
	
	<ul>
		<li>
			<a href="/project/browse/person/{$asigned}" title="View stories for {$asigned}">@{$asigned}</a>
			{section name=cst loop=$tags}
			<a href="/project/browse/tag/{$tags[cst]}" title="View stories tagged as '{$tags[cst]}'">#{$tags[cst]}</a> 
			{/section}
		</li>
	</ul>
</div>

<div class="story-actions">
	<ul>
		<li><a href="" class="status" title="Accept this story">Accept</a></li>
		<li><a href="" class="status" title="Reject this story">Reject</a></li>
	</ul>
</div>
