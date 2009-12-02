<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{$title}</title>
	<link rel="stylesheet" href="{$webdir}/perspectives/default/css/master.css" type="text/css" media="screen" title="master" charset="utf-8">
		
	<!-- Jquery CDN --> 
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
	
	<script src="{$webdir}/scripts/jquery.jeditable.1.7.1.min.js"></script>
	<script src="{$webdir}/scripts/jquery.autofill.js"></script>
	
	{literal}
	<script type="text/javascript">
	
	function test()
	{
		alert('test....');
		return false;
	}
	
	function pending()
	{
		alert('This functionality has not been implemented yet. We are working on it!');
		return false;
	}
	
	
	function close_notification()
	{
		$('#error_notification').slideUp();
		$.ajax({
					type: "POST",
					url: "/project/notifications",
					data:"clear=true",
					success: function(data) {/* left for future use */},
					error: function(x,data,code) {new_notification('error','Couldn\'t clear the notification.');}
				   
				 });
	}
	
	function new_notification(type, text)
	{
		$('#error_notification').slideUp();
		$('#notification_message').html(text);
		$('#error_notification').removeClass("error success");
		
		if (type == 'success')
		{
			$('#error_notification').addClass("success");
		}
		else
		{
			$('#error_notification').addClass("error");
		}
		
		$('#error_notification').slideDown("slow");
	}
	
	function get_notifications()
	{	
		$.ajax({
				   type: "POST",
				   url: "/project/notifications",
				   dataType:"json",
				   success: function(data)
							{
								if (data.success == true)
								{
									new_notification(data.data.css,data.data.message);
								}
							}
				   
				 });
		
		
	}
	
	function show_modal_dialog(message)
	{
		$('#modal_dialog').html(message);
		$('#modal_dialog').dialog('open');
		return false;
	}
	
	function close_modal_dialog()
	{
		$('#modal_dialog').dialog('close');
		return false;
	}
	
	 $(document).ready(function() 
	{
		$('#editable_project_name').editable('/project/update_field', 
								{
									indicator : 'Saving...',
									tooltip   : 'Click to edit',
									id   : 'field',
									style: 'font-size:0.8em;'
								});
									
		$('#close_notification').click(close_notification);
		get_notifications();
		
		
		$('#modal_dialog').dialog({autoOpen:false,draggable:false,modal:true,resizable:false,width:'61em'});

	});
	</script>
	{/literal}
	
	
</head>

<body>

<div id="session">
	<ul>
		<li>Claris</li>
		<!--  <li><a href="/project/plan" class="ok">&laquo; upgrade your account</a> (you are using 90% of your available space) --></li> 
		<li><a href="/seguridad/logout">logout</a></li>
		<li><a href="/project/settings">project settings</a></li>
		<li><a href="/project/people">people</a></li>
		<li><a href="/project/myprofile">{$person_name}</a></li>
	</ul>
</div>

<div class="notice span-12" id="error_notification" style="display:none;">
<p><span id="notification_message"></span><a id="close_notification" href="#">Close</a></p>
</div>

<div id="modal_dialog"></div>

<div id="wrapper" class="span-12">
	<h1><span class="editable" id="editable_project_name">{$description}</span></h1>
	
	<div id="nav" class="clearfix">
		<ul>	
			<li><a href="/project/dashboard" class="dashboard {if $active_dashboard}active{/if}">Dashboard</a></li>
			<li><a href="/project/browse" class="browse {if $active_browse}active{/if}">Browse</a></li>
			<li><a href="/project/metrics" class="metrics {if $active_metrics}active{/if}">Metrics</a></li>
		</ul>
	</div>
	
	<div id="inner-wrapper" class="clearfix">
	{$maincontent}
	</div>

	</div>
	
	<div id="footer-wrapper">
		<div id="footer">
			<div class="section">
				<h3>About</h3>
				
				<ul>
					<li><p><a href="">Blog</a></p></li>
					<li><p><a href="">Contact</a></p></li>
				</ul>
			</div>
			
			<div class="section">
				<h3>Help</h3>
				
				<ul>
					<li><p><a href="">FAQ</a></p></li>
					<li><p><a href="">Support</a></p></li>
				</ul>
			</div>
			
			<p class="copyright">&copy;2010, Claris. All rights reserved.</p>
			<p class="copyright"><a href="">Privacy Policy</a>. <a href="">Terms and Conditions</a>.</p>
		</div>
	</div>

	
</body>
</html>
