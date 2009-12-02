	<div id="inner-wrapper">
		<div id="page-header" class="clearfix">
			<div id="page-header-title">
				<h2>Browse</h2>
				
				<ul>
					<li><a href="{$webdir}/project/browse/dailyscrums">Daily scrums</a></li>
					<li><a href="{$webdir}/project/browse/sprints">Previous Sprints</a></li>
				</ul>
			</div>
		</div>
			
		<div id="content-wrapper" class="clearfix">
		
			<div class="col span-6">
				<div class="section clearfix">
					<div class="section-header clearfix">
						<div class="section-header-meta clearfix">
							<h3>Stories by person</h3>
						</div>
					</div>
					
					<div class="tags">
						<p>
							{section name=p loop=$people}
							<a href="{$webdir}/project/browse/person/{$people[p].name}" class="{$people[p].size}">{$people[p].name}</a>
							{/section}
						</p>
					</div>
				</div>
			</div>
			
			<div class="col last span-6">
				<div class="section clearfix">
					<div class="section-header clearfix">
						<div class="section-header-meta clearfix">
							<h3>Stories by tag</h3>
						</div>
					</div>
					
					<div class="tags">
						<p>
							{section name=t loop=$tags}
							<a href="{$webdir}/project/browse/tag/{$tags[t].name}" class="{$tags[t].size}">{$tags[t].name}</a>
							{/section}
						</p>
					</div>
				</div>
			</div>
			
		</div>
	</div>