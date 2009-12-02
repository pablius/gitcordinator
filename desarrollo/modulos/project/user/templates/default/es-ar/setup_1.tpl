{literal}
<script type="text/javascript">
			
					
			function is_name_available(name)
			{
				$.ajax({
						type: "POST",
						url: "/project/setup/2",
						data:{ name: name, availability: true},
						dataType:"json",
						success: function(data) 
						{	
							
							if (data.success == true)
							{
								$('#create_project').submit();
							}
							else
							{
								$('#error_message').slideUp();
								$('#error_message').slideDown();
							}
					   },
						error: function(x,data,code) {alert('It seems like we are having trouble connecting with our mothership!');}
					   
					 });
			}
			
			$(document).ready(function() 
			{
				
				$('#continue').click(function () 
				{ 
					is_name_available($('#project_name').attr('value'));
					return false;
				});


			});
		
	</script>

{/literal}

<div id="setup-wrapper">
<h2><strong>1</strong> ● <small>2</small> ● <small>3</small></h2>
<h3>Configure your account</h3>

<p>Configure your unique URL here. You'll need it to login your account.</p>
				
<form action="/project/setup/2" method="post" accept-charset="utf-8" id="create_project">
	<table>
		<tr>
			<th style="width: 70%">
				<input type="text" name="name" value="" id="project_name" />
				<p id="error_message" class="tooltip" style="display:none;">The url you entered is not available.</p>
			</th>
			<td>
				<span>.clarisapp.com</span>
			</td>
		</tr>
		<tr>
			<th />
			<td>
				<input name="continue" type="submit" id="continue" class="button"  value="Continue &raquo;">
			</td>
		</tr>
	</table>
</form>
</div>