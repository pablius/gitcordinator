{literal}
<script type="text/javascript">

	var add_people_text = '@username @otherusername';
	var invite_text = 'enter e-mail address';

	function show_invite_box()
	{
		var id = this.id.split("_")[1];
		
		$("#invite_" + id).show();
		$("#email_" + id).show();
		return false;
	}
	
	function send_invite()
	{
		var id = this.id.split("_")[1];
		if ($("#email_" + id).val() == invite_text)
		{
			$("#email_" + id).addClass("error");
			return false;
		}
		else
		{
			return _send_invite(id);
		}

	}
	
	function _send_invite(id)
	{
		var email = $("#email_" + id).val();

		
		$("#email_" + id).removeClass("error");
	
		// loading wheel
		$("#invite_" + id).ajaxStart(function(){
		   $(this).addClass("loader");
		});
		
		$("#invite_" + id).ajaxStop(function(){
		   $(this).removeClass("loader");
		}); 

		$.ajax({
					type: "POST",
					url: "/project/people/invite",
					dataType:"json",
					data: {email: email, name: id},
					success: function(data) {
						
						if (data.success == true)
						{
							window.location.reload();	
						}
						else
						{
							alert (data.data);
							new_notification('error', data.data);
							$("#email_" + id).addClass("error");
						}
						
						
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t invite this person.');}
				   
				 });
		
		return false;
	
	}
	
	function delete_person()
	{
		var name = this.id.split("_")[1];
		return _delete_person(name);
	}
	
	function _delete_person(name)
	{
		
		$.ajax({
					type: "POST",
					url: "/project/people/delete",
					dataType:"json",
					data: {name: name},
					success: function(data) {
						
						if (data.success == true)
						{
							window.location.reload();	
						}
						else
						{
							alert (data.data);
							new_notification('error', data.data);
						}
						
						
				   },
					error: function(x,data,code) {new_notification('error', 'We couldn\'t delete this person.');}
				   
				 });
		
		return false;
	
	}
	
	
	

	$(function() {
	
		
		
		 $(document).ready(function() 
		{
			
			$("a[id^='invite_']").bind('click', send_invite);
			$("a[id^='resend_']").bind('click', show_invite_box );
			$("a[id^='delete_']").bind('click', delete_person );
			

			$('#add_people').autofill({
				value: add_people_text,
				defaultTextColor: '#cccccc',
				activeTextColor: '#555555'
			});
			
			$("[id^='email_']").autofill({
				value: invite_text,
				defaultTextColor: '#cccccc',
				activeTextColor: '#555555'
			});
			
			$('#add_people_button').click(function () 
			{ 
				if ($('#add_people').val() == add_people_text)
				{
					return false;
				}
				else
				{
					return true;
				}
			});
			
		});
		
	});
	</script>

{/literal}

<div id="page-header" class="clearfix">
	<div id="page-header-title">
		<h2>People</h2>
	</div>
	
	<div id="page-header-action">
		<form method="POST">
			<input type="text" name="add_people" id="add_people" value="" />
			<input type="submit" name="add" value="Add" class="mini-button" id="add_people_button" />
		</form>
				
	</div>
</div>
	
<div id="content-wrapper" class="clearfix">
		<div class="col last span-12">
			<div class="persons-header clearfix">
				<ul>
					<li class="name"><strong>Name</strong></li>
					<li class="availability"><strong>Availability</strong></li>
					<li><strong>Status</strong></li>
				</ul>
			</div>
			{section name=p loop=$people}
			<dl class="person clearfix">
				<dt><img height="48" width="48" src="{$people[p].picture}" alt="Avatar" /></dt>
				<dd class="name">
					<ul>
						<li><a href="{$webdir}/project/browse/person/{$people[p].name}" title="View stories for @{$people[p].name}">@{$people[p].name}</a></li>
						<li>{if $people[p].bio != ''}{$people[p].bio}{/if}</li>
						<li>{if $people[p].url != ''}<a href="{$people[p].url}">{$people[p].url}</a>{/if}</li>
					</ul>
				</dd>
				<dd class="availability">
					<select>
						<option>100%</option>
						<option>90%</option>
						<option>Not available</option>
					</select>
				</dd>
				<dd class="status">
				{if $people[p].invite}
					<p><strong>Not yet invited.</strong> Invite this user to collaborate in this project:</p>
				{else}
					<p><strong>Invited.</strong> <a href="#" id="resend_{$people[p].name}">Resend access credentials</a></p>
				{/if}				
					<input type="text" {if !$people[p].invite}style="display:none;"{/if} name="email_{$people[p].name}" value="" id="email_{$people[p].name}" />
					<a href="#" {if !$people[p].invite}style="display:none;"{/if} id="invite_{$people[p].name}" class="mini-button">Send</a>
				</dd>
				<dd class="delete" style="float:right;">
					<a href="#" id="delete_{$people[p].name}" class="mini-button">Delete</a>
				</dd>
			</dl>
			{/section}
			
		</div>
	</div>

