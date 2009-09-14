{literal}
<script type="text/javascript">
	$(function() {
		$(".story_list").sortable(
								{  opacity: 0.6, 
								   revert: true, 
								   scroll: true,
								   dropOnEmpty :true,
								   connectWith: ['#current_sprint','#product_backlog','#unplaned_stories'],
								   receive : function () 
														{ 
															//var current_count = $("#current_sprint div.story").size();
															//alert (current_count);
															
															var current =  $('#current_sprint').sortable('serialize');
															var pb =  $('#product_backlog').sortable('serialize');
															var unplanned = $('#unplaned_stories').sortable('serialize');
															
															// update claris according to screen data
															 $.post("/project/dashboard_store", { current: current, pb: pb, unplanned: unplanned},
															   function(data){
																												
																 if (data.success == true)
																 {
																	$('#current_sprint_count').html(data.data.current_sprint_count);
																	$('#pb_count').html(data.data.pb_count);
																	$('#unplaned_count').html(data.data.unplaned_count);
																 }
																 else
																 {
																	alert ('We couldn\'t store your dashboard. Please refresh');
																 }
															   },"json");
															
														} 
								});
								
	
		$(".story_list").disableSelection();
		
	
		
	});
	</script>

{/literal}
	<div id="page-header">
		<div id="page-header-title">
			<h2>Sprint {$sprint_number}: <span class="editable">{$sprint_goal}</span></h2>
		
			<ul>
				<li><a href="/project/sprint_finish">Finish this sprint</a></li>
				<li><a href="/project/daily_scrum">Daily scrum</a></li>
			</ul>
		</div>
		
		<div id="page-header-action">
			<form method="POST" action="{$webdir}/project/story_shortnew">
			<table class="add-story">
				<tr>
					<td>
						<input type="text" name="story" value="" id="new_short_story" />
					</td>
					<td>
						<input type="submit" class="button" value="Add story" />
					</td>
				</tr>
				<tr>
					<td colspan="2"><p><small>Use: "New sign up form @pablius #interface" <a href="">More help</a></small></p></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	
	<div id="content-wrapper">
		<div class="col span-6">
			<div class="module">
				<div class="module-header">
					<h3>In Progress <small>(this sprint)</small> <span id="current_sprint_count">{$current_sprint_total}</span></h3>
				</div>
				<div id="current_sprint" class="story_list">
				{section name=cs loop=$current_sprint}
				
				<div class="story" id="story_{$current_sprint[cs].number}">
					<div class="story-meta col last span-1">
						<ul>
							<li class="number"><a href="/project/story/view/{$current_sprint[cs].number}">{$current_sprint[cs].number}</a></li>
						</ul>
					</div>
					
					<div class="story-description">
						<div class="story-title">
							<h4 class="small"><span class="editable" title="Click to edit">{$current_sprint[cs].name}</span></h4>
						</div>
						
						<div class="story-details">
							<ul>
								<li>
									<p>
										<a href="/project/browse/person/{$current_sprint[cs].asigned}" title="View stories for {$current_sprint[cs].asigned}">@{$current_sprint[cs].asigned}</a> 
										{section name=cst loop=$current_sprint[cs].tags}
										<a href="/project/browse/tag/{$current_sprint[cs].tags[cst]}" title="View stories tagged as '{$current_sprint[cs].tags[cst]}'">#{$current_sprint[cs].tags[cst]}</a> 
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
		</div>
		
		<div class="col span-3">
			<div class="module">
				<div class="module-header">
					<h3>To-do <small>(product backlog)</small> <span id="pb_count">{$product_backlog_total}</span></h3>
				</div>
				
				<div id="product_backlog" class="story_list">
				{section name=pb loop=$product_backlog}
				
				<div class="story"  id="story_{$product_backlog[pb].number}">
					<div class="story-meta col last span-1">
						<ul>
							<li class="number"><a href="/project/story/view/{$product_backlog[pb].number}">{$product_backlog[pb].number}</a></li>
						</ul>
					</div>
					
					<div class="story-description">
						<div class="story-title">
							<h4 class="small"><span class="editable" title="Click to edit">{$product_backlog[pb].name}</span></h4>
						</div>
						
						<div class="story-details">
							<ul>
								<li>
									<p>
										<a href="/project/browse/person/{$product_backlog[pb].asigned}" title="View stories for {$product_backlog[pb].asigned}">@{$product_backlog[pb].asigned}</a> 
										{section name=pbt loop=$product_backlog[pb].tags}
										<a href="/project/browse/tag/{$product_backlog[pb].tags[pbt]}" title="View stories tagged as '{$product_backlog[pb].tags[pbt]}'">#{$product_backlog[pb].tags[pbt]}</a> 
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
		</div>
		
		<div class="col last span-3">
			<div class="module">
				<div class="module-header">
					<h3>Unplanned Stories <span id="unplaned_count">{$unplaned_total}</span></h3>
				</div>
				<div id="unplaned_stories" class="story_list">
				{section name=u loop=$unplaned}
				
				<div class="story" id="story_{$unplaned[u].number}">
					<div class="story-meta col last span-1">
						<ul>
							<li class="number"><a href="/project/story/view/{$unplaned[u].number}">{$unplaned[u].number}</a></li>
						</ul>
					</div>
					
					<div class="story-description">
						<div class="story-title">
							<h4 class="small"><span class="editable" title="Click to edit">{$unplaned[u].name}</span></h4>
						</div>
						
						<div class="story-details">
							<ul>
								<li>
									<p>
										<a href="/project/browse/person/{$unplaned[u].asigned}" title="View stories for {$unplaned[u].asigned}">@{$unplaned[u].asigned}</a> 
										{section name=ut loop=$unplaned[u].tags}
										<a href="/project/browse/tag/{$unplaned[u].tags[ut]}" title="View stories tagged as '{$unplaned[u].tags[ut]}'">#{$unplaned[u].tags[ut]}</a> 
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
		</div>
	</div>
