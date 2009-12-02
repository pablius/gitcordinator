<div id="page-header">
	<div class="col span-8">
		<h2>{$number} - {$name}</h2>
	
		<ul>
			<li>by <a href="{$webdir}/project/browse/person/{$assigned}">@{$assigned}</a>, {$date|relativedate}</li>
		</ul>
	</div>
	
	<div class="col last span-4">
		<ul>
			<li>Status: {$state}</li>
			<li>Demo: {$demo}</li>
			<li>Description: {$description}</li>
			<li>Estimate: {$estimate}</li>
		</ul>
	</div>
</div>

<div id="content-wrapper">
	<div class="tags">
		<p>
			{section name=t loop=$tags}
			<a href="{$webdir}/project/browse/tag/{$tags[t].name}" >#{$tags[t].name}</a>
			{/section}
		</p>
	</div>


</div>
