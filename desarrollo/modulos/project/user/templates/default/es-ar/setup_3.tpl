<div id="setup-wrapper">
	<h2><small>1</small> ● <small>2</small> ● <strong>3</strong></h2>
	<h3>Add your first story</h3>
	
	<p>To get started, let's add your first story. For example, "Redesign login form @lebowsky #interface". Use @ to link this story to a person, and # to tag it. Don't worry about people and tags, they will be interpreted and added automagically.</p>
	
	<form action="" method="post" accept-charset="utf-8">
		<table>
			<tr>
				<th style="width: 70%">
					<input type="text" name="new_story" value="" id="new_story" />
					{if $error}
						<small>There is an error with the story you are trying to add. You can only add one @user.</small>
					{/if}
				</th>
				<td>
					<input type="submit" name="create" value="Add story &amp; Finish" id="some_name" class="button" /> 
				</td>
			</tr>
		</table>
	</form>
</div>