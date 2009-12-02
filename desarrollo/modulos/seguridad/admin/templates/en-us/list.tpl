
  <table width="100%"  border="0">
    <tr>
      <td valign="top">  <h1>User List </h1>
      <td valign="top"><form name="kind" method="post" action="{$webdir}/seguridad/list">
          <div align="right">
            <select name="kind_select">
              
            
	     {html_options values=$kind_values selected=$method output=$kind_names}
        
          
            </select>
            <input name="kind_order" type="hidden" value="{$order}">
            <input name="kind_submit" type="submit" value="Show">
          </div>
      </form>
    </tr>
  </table>
  <hr class="barra">

<table width="100%"  border="0">
  <tr>
    <td valign="top"> <font class="small">This is the list of registered users on the system </font>          </tr>

  <tr>
    <td valign="top">
	 <br>
You are seeing {$method}  users.
       				<br>  <br>  <br>
       				<form name="change" method="post" action="{$webdir}/seguridad/list">
       				<table width="100%" border="0">
                      <tr>
                        <td><div align="left"><a href="{$webdir}/seguridad/list/{$method}/uname"><strong>Login</strong></a></div></td>
                        <td><div align="center"><a href="{$webdir}/seguridad/list/{$method}/email"><strong>E-Mail</strong></a></div></td>
                        <td><div align="right"><a href="{$webdir}/seguridad/list/{$method}/status"><strong>Status</strong></a></div></td>
                      <td width="10"></td>
                      </tr>
                     {section name=u loop=$usuarios}
					  <tr>
                        <td><strong><a href="{$webdir}/seguridad/update/{$usuarios[u].id}">{$usuarios[u].uname}</a></strong></td>
                        <td align="center" >{$usuarios[u].email}</td>
                        <td align="right" >{$usuarios[u].status}</td>
                        <td><input type="checkbox" name="selected_users[]" value="{$usuarios[u].id}"></td>
                      </tr>
					  {sectionelse}
					   <tr><td colspan="3"> No records found. </td>
					   </tr>
					  {/section}
      </table>       				
<hr>

          <div align="right">
          Set selected user/s status:
            <select name="change_select">
              
            
	     {html_options values=$change_values output=$change_values}
        
          
            </select>
            <input name="select_submit" type="submit" value="Update">
          </div>
      </form>
<hr>
  </tr>

</table>

