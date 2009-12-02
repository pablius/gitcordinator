{literal}
<script type="text/javascript">

	function daily_scrum()
	{
		
		$.ajax({
					type: "GET",
					url: "/project/daily/scrum/",
					dataType:"json",
					success: function(data) {

					if (data.success == true)
					{
						
						show_modal_dialog(data.data);
						// bind save
						$("#save_daily_scrum").bind('click', save_daily_scrum);
						// bind close
						$("#close_modal_dialog").bind('click', close_modal_dialog);
					}
					 
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t delete this story.');}
				   
				 });
		
		return false;
	}
	
	function save_daily_scrum()
	{
		var today = $('#ds_today').val();
		var yesterday = $('#ds_yesterday').val();
		var blocks = $('#ds_blocks').val();
		$.ajax({
					type: "POST",
					url: "/project/daily/scrum/",
					dataType:"json",
					data:{today:today,yesterday:yesterday,blocks:blocks},
					success: function(data) {

					if (data.success == false)
					{
						show_modal_dialog(data.data);
						// bind save
						$("#save_daily_scrum").bind('click', save_daily_scrum);
						// bind close
						$("#close_modal_dialog").bind('click', close_modal_dialog);
					}
					else
					{
						close_modal_dialog();
					}
					 
					 
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t delete this story.');}
				   
				 });
		
		return false;
	}
	
	function delete_story()
	{
		var id = this.id.split("_")[1];
		if (!confirm('Are you sure that you want to delete this story? This action is irreversible.'))
		{
			return false;
		}
		else
		{
			return _delete_story(id);
		}
	}
	
	function _delete_story(id)
	{
		var parent = $('#story_' + id).parent().attr('id');

		$.ajax({
					type: "POST",
					url: "/project/story/delete/" + id,
					dataType:"json",
					data: {parent: parent},
					success: function(data) {

					if (data.success == true)
					{
						$('#story_' + id).slideUp();
						// update container estimate 
						$(data.data.counter).html(data.data.count);
					}
					 else
					 {
						new_notification('error', 'We couldn\'t delete this story.');
					 }
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t delete this story.');}
				   
				 });
		
		return false;
	}
	
	
	function edit_story()
	{
		var id = this.id.split("_")[1];
		return _edit_story(id);
	}
	
	function _edit_story(id)
	{
	
		$.ajax({
					type: "POST",
					url: "/project/story/edit/" + id,
					dataType:"json",
					success: function(data) {

					 if (data.success == true)
					 {
						$('#story_' + id).addClass('edit');
						$('#story_' + id).html(data.data);
						
						// bind story actions
						$("a[id^='discard_']").bind('click', discard_story_edit);
						$("a[id^='update_']").bind('click', update_story);
						$("a[id^='delete_']").bind('click', delete_story);
						

					 }
					 else
					 {
						new_notification('error', 'We couldn\'t load this story.');
					 }
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t load this story.');}
				   
				 });
		
		return false;
	}
	
	function update_story()
	{
		var id = this.id.split("_")[1];
		return _update_story(id);
	}
	
	function _update_story(id)
	{
		
		// loading wheel
		$('#updateli_' +id).ajaxStart(function(){ 
			$(this).addClass("loader");
		});
		
		$('#updateli_' +id).ajaxStop(function(){
		   $(this).removeClass("loader");
		});
		
		var meta = $('#meta_' +id).val();
		var demo = $('#demo_' +id).val();
		var description = $('#description_' +id).val();
		var estimate = $('#estimate_' +id).val();
	
	
		$.ajax({
					type: "POST",
					url: "/project/story/edit/" + id,
					dataType:"json",
					data:{ meta: meta, demo: demo, description: description, estimate: estimate},
					success: function(data) {
					
					 if (data.success == false)
					 {
						$('#story_' + id).html(data.data);
						
						// bind story actions
						$("a[id^='discard_']").bind('click', discard_story_edit);
						$("a[id^='update_']").bind('click', update_story);
						$("a[id^='delete_']").bind('click', delete_story);
						
					 }
					 else
					 {
						_discard_story_edit(id);
					 }
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t update this story.');}
				   
				 });
		
		return false;
	}
	
	function discard_story_edit()
	{
		var id = this.id.split("_")[1];
		return _discard_story_edit(id);
	}
	
	function _discard_story_edit(id)
	{
		
		$.ajax({
					type: "GET",
					url: "/project/story/simpleview/" + id,
					dataType:"json",
					success: function(data) {

					 if (data.success == true)
					 {
						$('#story_' + id).removeClass('edit');
						$('#story_' + id).html(data.data);
						
						// bind story actions
						$("a[id^='edit_']").bind('click', edit_story );
					 }
					 else
					 {
						new_notification('error', 'We couldn\'t load this story.');
					 }
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t load this story.');}
				   
				 });
		
		return false;
	}
	
	
	
	function finish_sprint()
	{
		
		$.ajax({
					type: "GET",
					url: "/project/sprint/finish",
					dataType:"json",
					success: function(data) {

					 if (data.success == true)
					 {
						alert ("The sprint is now finished. All remaining stories have been moved to the next sprint.");
						window.location.reload(true);
					 }
					 else
					 {
						new_notification('error', 'We couldn\'t finish the sprint.');
					 }
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t finish the sprint.');}
				   
				 });
		
		return false;
	}
	
	
	$(function() {
	
	
		$(".story_list").sortable(
		{  opacity: 0.6, 
		   revert: true, 
		   scroll: true,
		   dropOnEmpty :true,
		   connectWith: ['#current_sprint','#product_backlog','#unplaned_stories'],
		   stop : function (event,ui) 
								{ 
									var id_dropped_element = ui.item.attr('id');
																					
									var current =  $('#current_sprint').sortable('serialize');
									var pb =  $('#product_backlog').sortable('serialize');
									var unplanned = $('#unplaned_stories').sortable('serialize');
									
									// update claris according to screen data
									$.ajax({
										type: "POST",
										url: "/project/dashboard/store",
										data:{ current: current, pb: pb, unplanned: unplanned},
										dataType:"json",
										success: function(data) {
										
										 if (data.success == true)
										 {
											$('#current_sprint_count').html(data.data.current_sprint_count);
											$('#pb_count').html(data.data.pb_count);
											$('#unplaned_count').html(data.data.unplaned_count);
											
											_discard_story_edit(id_dropped_element.split("_")[1]);
										 }
										 else
										 {
											new_notification('error', 'We couldn\'t store your dashboard.');
										 }
									   },
										error: function(x,data,code) {new_notification('error','We couldn\'t store your dashboard. Please refresh');}
									   
									 });
								}
			

								
		});
								
	
		// $(".story_list").disableSelection();
		
		 $(document).ready(function() 
		{
			
			var new_short_story_text = 'Write your story here @username #tag';
			
			$('#editable_goal').editable('/project/update_field', 
			{
				indicator : 'Saving...',
				tooltip   : 'Click to edit',
				id   : 'field',
				style: 'font-size:0.8em;'
			});
			
			$('#new_short_story').autofill({
				value: new_short_story_text,
				defaultTextColor: '#cccccc',
				activeTextColor: '#555555'
			});
			
			$('#new_short_story_button').click(function () { 
			  if ($('#new_short_story').attr('value') == new_short_story_text)
			  {
				return false;
			  }
			  else
			  {
				// loading wheel
				$('#new_short_story_li').ajaxStart(function(){
				   $(this).addClass("loader");
				});
				
				$('#new_short_story_li').ajaxStop(function(){
				   $(this).removeClass("loader");
				});

			  
				$.ajax({
					type: "POST",
					url: "/project/story_shortnew",
					data:{ story: $('#new_short_story').attr('value')},
					dataType:"json",
					success: function(data) {
																	
					 if (data.success == true)
					 {
						$('#new_short_story').attr('value',new_short_story_text);
						$('#unplaned_stories').html(data.data.unplanned);
						$('#unplaned_count').html(data.data.unplanned_count);
					 }
					 else
					 {
						new_notification('error', 'We couldn\'t create the story as you typed it. Remeber you can only assign the story to one @person.');
					 }
				   },
					error: function(x,data,code) {new_notification('error','We couldn\'t create the story, there was a problem comunicating with Claris');}
				   
				 });
			  }
			});

			$("a[id^='edit_']").bind('click', edit_story );
			$("#finish_sprint").bind('click', finish_sprint);
			$("#add_deadline").bind('click', pending);
			$("#daily_scrum").bind('click', daily_scrum);
			
		});
		
	});
	</script>

{/literal}

<div id="page-header" class="clearfix">
	<div id="page-header-title">
		<h2>Dashboard</h2>
		
		<ul>
			<li><a href="#" id="daily_scrum">Daily scrum</a></li>
		</ul>
	</div>
	
	<div id="page-header-action">
		<input type="text" name="story" id="new_short_story" value="" />
		
		<ul>
			<li id="new_short_story_li"><a href="#" id="new_short_story_button" class="mini-button">Add story</a></li>
			<li class="tooltip"><a href="">Syntax help.</a></li>
		</ul>
	</div>
</div>

<div id="content-wrapper" class="clearfix">
	<div class="col span-6">
		<div class="section clearfix">
			<div class="section-header clearfix">
				<div class="section-header-meta clearfix">
					<h3>Sprint {$sprint_number}: 
						<span class="editable" title="Edit" id="editable_goal">{$sprint_goal}</span>
					</h3>
					
					<ul>
				<!--		<li><a href="#">Add deadline</a></li> -->
						<li><a href="#" id="finish_sprint">Finish this sprint</a></li>
					</ul>
				</div>
				
				<div class="section-header-info">
					<span class="points" title="Total points" id="current_sprint_count">{$current_sprint_total}</span>
					<span class="date" title="Sprint date">{$sprint_start_date} &ndash; {$sprint_end_date}
				</div>
			</div>
			<div class="story_list" id="current_sprint">
			{section name=cs loop=$current_sprint}
				<div class="story clearfix" title="Drag this story" id="story_{$current_sprint[cs].number}">
					<div class="story-expand">
						<ul>
							<li><a href="#" class="icon-arrow {$current_sprint[cs].text_class}" id="edit_{$current_sprint[cs].number}" title="Edit this story">Edit</a></li>
						</ul>
					</div>
					
					<div class="story-description">
						<h4 class="{$current_sprint[cs].text_class}">
							<span class="number" title="Story ID">{$current_sprint[cs].number}</span>
							<a href="/project/story/view/{$current_sprint[cs].number}" title="View source for this story">{$current_sprint[cs].name}</a>
						</h4>
						
						<ul>
							<li>
								<a href="/project/browse/person/{$current_sprint[cs].asigned}" title="View stories for {$current_sprint[cs].asigned}">@{$current_sprint[cs].asigned}</a>
								{section name=cst loop=$current_sprint[cs].tags}
								<a href="/project/browse/tag/{$current_sprint[cs].tags[cst]}" title="View stories tagged as '{$current_sprint[cs].tags[cst]}'">#{$current_sprint[cs].tags[cst]}</a> 
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
				</div>
				{/section}
			</div>
		</div>
	</div>
	
	<div class="col last span-6">
		<div class="section clearfix">
			<div class="section-header clearfix">
				<div class="section-header-meta clearfix">
					<h3>Product Backlog</h3>
					
					<ul>
						<li><a href="#" id="add_deadline">Add deadline</a></li>
					<!--	<li><a href="">Add sprint</a></li>  -->
					</ul>
				</div>
				
				<div class="section-header-info">
					<span class="points" title="Total points" id="pb_count">{$product_backlog_total}</span>
				</div>
			</div>
			
			<div id="product_backlog" class="story_list">
			{section name=pb loop=$product_backlog}
				<div class="story clearfix" title="Drag this story"  id="story_{$product_backlog[pb].number}">
					<div class="story-expand">
						<ul>
							<li><a href="#" class="icon-arrow {$product_backlog[pb].text_class}" id="edit_{$product_backlog[pb].number}" title="Edit this story">Edit</a></li>
						</ul>
					</div>
					
					<div class="story-description">
						<h4 class="{$product_backlog[pb].text_class}">{$product_backlog[pb].name}</h4>
						
						<ul>
							<li>
								<a href="/project/browse/person/{$product_backlog[pb].asigned}" title="View stories for {$product_backlog[pb].asigned}">@{$product_backlog[pb].asigned}</a> 
								{section name=pbt loop=$product_backlog[pb].tags}
								<a href="/project/browse/tag/{$product_backlog[pb].tags[pbt]}" title="View stories tagged as '{$product_backlog[pb].tags[pbt]}'">#{$product_backlog[pb].tags[pbt]}</a> 
								{/section}					
							</li>
						</ul>
					</div>
				</div>
			{/section}
			</div>
			
			<div class="sprint-marker">
				<h4>Unplanned stories (<span id="unplaned_count">{$unplaned_total}</span>)</h4>
			</div>
			
			<div id="unplaned_stories" class="story_list">
			{section name=u loop=$unplaned}
				<div class="story clearfix" title="Drag this story"  id="story_{$unplaned[u].number}">
					<div class="story-expand">
						<ul>
							<li><a href="#" class="icon-arrow {$unplaned[u].text_class}" id="edit_{$unplaned[u].number}" title="Edit this story">Edit</a></li>
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
			</div>
			
		</div>
	</div>
</div>

