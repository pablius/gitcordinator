<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{$title}</title>
	<link rel="stylesheet" href="{$webdir}/perspectives/default/css/master.css" type="text/css" media="screen" title="master" charset="utf-8">
</head>

<body>

<div id="session">
	<ul>
		<li>Claris</li>
		<!--  <li><a href="/project/plan" class="ok">&laquo; upgrade your account</a> BLOQUE ESTADO DE PLAN(you are using 90% of your available space) --></li> 
		<li><a href="/seguridad/logout">logout</a></li>
		<li><a href="/project/settings">project settings</a></li>
		<li><a href="/project/people">people</a></li>
		<li><a href="/project/myprofile">{$currentUser}</a></li>
	</ul>
</div>

<div id="wrapper" class="span-12">
	<h1><span class="editable">{$description}</span></h1>
	
	<div id="nav">
		<ul>	
			<li><a href="/project/dashboard" class="dashboard {if $active_dashboard}active{/if}">Dashboard</a></li>
			<li><a href="/project/browse" class="browse {if $active_browse}active{/if}">Browse</a></li>
			<!-- <li><a href="/project/messages" class="messages">Messages</a></li> --> 
			<li><a href="/project/metrics" class="metrics {if $active_metrics}active{/if}">Metrics</a></li>
		</ul>
	</div>
	
	<div id="inner-wrapper">
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
			
			<p class="copyright">&copy;2009 Claris. All rights reserved.</p>
			<p class="copyright"><a href="">Privacy Policy</a>. <a href="">Terms and Conditions</a>.</p>
		</div>
	</div>

</body>
</html>
