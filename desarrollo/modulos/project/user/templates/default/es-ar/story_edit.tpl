<div class="story-expand">
	<ul>
		<li><a href="#" id="discard_{$number}" class="icon-arrow expanded" title="Discard changes to this story">Discard</a></li>
	</ul>
</div>

<div class="story-description">
<form action="" method="post" >
	<table class="story-details">
		<tr>
			<th colspan="2" style="padding-top: 0">
				<input type="text" name="meta" value="{$meta}" id="meta_{$number}" {if $META_MULTIPLEUSERS || $META_PERSON_FAIL || $META_SHORT || $NO_NAME}class="error"{/if}/>
				{if $META_MULTIPLEUSERS}<p class="tooltip">You can only assign the story to one person.</p>{/if}
				{if $META_PERSON_FAIL}<p class="tooltip">The @person you typed could not be created.</p>{/if}
				{if $META_SHORT}<p class="tooltip">Text should be longer, remember to specify an @user and relevant #tags.</p>{/if}
				{if $NO_NAME}<p class="tooltip">The story name contains unallowed chars.</p>{/if}

			</th>
		</tr>
		<tr>
			<th><label for="estimate">Estimate</label></th>
			<td>
				<select id="estimate_{$number}" name="estimate">
					{html_options options=$estimates_array selected=$estimate}
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="description">Description</label></th>
			<td>
				<textarea id="description_{$number}" name="description" {if $NO_DESCRIPTION}class="error"{/if}>{$description}</textarea>
				{if $NO_DESCRIPTION}<p class="tooltip">Description contains an invalid text.</p>{/if}
			</td>
		</tr>
		<tr>
			<th><label for="demo">How to demo</label></th>
			<td>
				<textarea id="demo_{$number}" name="demo" {if $NO_DEMO}class="error"{/if}>{$demo}</textarea>
				{if $NO_DEMO}<p class="tooltip">How-to demo contains an invalid text.</p>{/if}
			</td>
		</tr>
		<tr>
			<th />
			<td>
				<ul class="form-actions">
					<li id="updateli_{$number}" >
						<a id="update_{$number}" href="#" class="mini-button" style="display: inline">Save</a> or <a href="#" id="discard_{$number}">dismiss</a>
					</li>
					<li style="margin-top: -2px; float: right;">
						<a id="delete_{$number}" href="#" class="icon-delete" title="Delete this story">Delete</a>
					</li>
				</ul>
			</td>
		</tr>
	</table>
</form>
</div>

