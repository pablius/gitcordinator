<div id="page-header">
	<div id="page-header-title">
		<h2>Daily Scrum for Today</h2>
	</div>
	
	<div id="page-header-action">
		
	</div>
</div>

<div id="content-wrapper">

	<form action="" method="post" accept-charset="utf-8">
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="yesterday">Yesterday</label>
			</div>
			<div class="col last span-5">
				<textarea name="yesterday" id="yesterday" class="col span-4" rows="4">{$yesterday}</textarea>
			</div>
			<div class="col last span-5">
				<p>Here explain what you did yesterday. Be as specific as needed.</p>
			</div>
		</div>
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="today">Today</label>
			</div>
			<div class="col last span-5">
				<textarea name="today" id="today" class="col span-4" rows="4">{$today}</textarea>
			</div>
			<div class="col last span-5">
				<p>Here explain what you'll be doing today, that will help the Scrum Master plan and organize the team's work.</p>
			</div>
		</div>
		
		<div class="field no-border">
			<div class="col span-2">
				<label for="blocks">Blocks</label>
			</div>
			<div class="col last span-5">
				<textarea name="blocks" id="blocks" class="col span-4" rows="4">{$blocks}</textarea>
			</div>
			<div class="col last span-5">
				<p>If something or someone is blocking your work, let the Scrum Master know here, he'll help you out!</p>
			</div>
		</div>
		
		<div class="field">
			<div class="col last span-4 nudge-2">
				<input type="submit" name="save" value="Save" id="save" />
			</div>
		</div>
		
	</form>
</div>
