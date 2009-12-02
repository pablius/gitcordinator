<div id="daily-scrum">	
	<h1>Daily scrum for Today</h1>
	<table>
		<tr>
			<th><label for="yesterday">1. What have you done yesterday?</label></th>
			<td><textarea name="yesterday" {if $NO_YESTERDAY}class="error"{/if} id="ds_yesterday">{$yesterday}</textarea></td>
		</tr>
		<tr>
			<th><label for="today">2. What will you do today?</label></th>
			<td><textarea name="today" {if $NO_TODAY}class="error"{/if}  id="ds_today">{$today}</textarea></td>
		</tr>
		<tr>
			<th><label for="impediments">3. What (or Who) is blocking your work?</label></th>
			<td>
				<textarea name="blocks" {if $NO_BLOCKS}class="error"{/if} id="ds_blocks">{$blocks}</textarea>
			</td>
		</tr>
		<tr>
			<th />
			<td>
				<ul class="form-actions">
					<li>
						<a href="#" id="save_daily_scrum" class="mini-button" style="display: inline">Save</a> or 
						<a href="#" id="close_modal_dialog">dismiss</a></li>
				</ul>
			</td>
		</tr>
	</table>
</div>