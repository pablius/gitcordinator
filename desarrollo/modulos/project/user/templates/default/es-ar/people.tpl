<div id="page-header">
	<div id="page-header-title">
		<h2>People</h2>
	</div>
	
	<div id="page-header-action">
		<form method="POST">
		<input type="text" name="add_people" id="add_people" value="@username" />
		<input type="submit" name="add" value="Add" class="mini-button right" />
		</form
	</div>
</div>

<div id="content-wrapper">
	<div class="col span-8">
		{section name=p loop=$people}
		<dl class="person">
			<dt><img height="48" width="48" src="{$people[p].picture}" alt="Avatar" /></dt>
			<dd>
				<p><a href="{$webdir}/browse/people/{$people[p].name}">@{$people[p].name}</a></p>
			</dd>
			<dd>
			{if $people[p].invite}
				<p>Invite this user to collaborate in this project.</p>
				{if $people[p].invite_fail}
				<p>Invite could not be sent, check e-mail address and try again.</p>
				{/if}
				<form method="POST" action="">
					<input type="hidden" name="name" value="{$people[p].name}" id="name" />
					<input type="text" name="email" value="e-mail address" id="email" />
					<input type="submit" name="invite" value="Invite" id="invite" class="submit" />
				</form>
			{else}
				<p>{$people[p].bio}</p>
				{if $people[p].url != ''}<p><a href="{$people[p].url}">{$people[p].url}</a></p>{/if}
			{/if}
			</dd>
		</dl>
		{/section}
		
	</div>
	
	<div class="col last span-4">
		<div class="section">
			<h3>People activity</h3>
			<p>See how busy is each member of your team.</p> 
			
			<div class="tags">
				<p>
					{section name=t loop=$people_tags}
						<a href="{$webdir}/project/browse/person/{$people_tags[t].name}" class="{$people_tags[t].size}">{$people_tags[t].name}</a>
					{/section}
				</p>
			</div>
		</div>
	</div>
</div>