<form name="login" method="post" action="{$webdir}/seguridad/update">
 <h1>Update User data </h1>
  <hr class="barra">

<table width="100%"  border="0">
  <tr>
    <td valign="top">
{if $error}
	   <div class="error">
         <ul><font class="error">Error:</font>
           {if $INVALID_PASS}     <li>Invalid password (4 to 8 alphanumeric characters)</li>{/if}
         {if $NO_CONCUERDAN}      <li>Passwords don´t match</li>{/if}
   {if $INVALID_EMAIL}            <li>Invalid e-mail address</li>{/if}
         </ul>
       </div>
        {/if}

	  <h2>User <br>
          <input name="uname" type="text" id="uname" value="{$uname}" readonly="true">
      </h2>
      <h2>Password<br>

          <input name="pass" type="password" id="pass" maxlength="8">
          <input name="passtwo" type="password" id="passtwo" maxlength="8">
</h2>
<font class="small">(you must type the password twice to validate it)</font>
<h2>E-Mail<br>
<input name="email" type="text" id="email" value="{$email}"> 
</h2>
<h2>Estado<br> 

       <select name="status_select">
              
            
	     {html_options values=$status_values selected=$status output=$status_names}
        
          
            </select>  </h2><br>
      <input name="id" type="hidden" value="{$id}">
      <input name="update" type="submit" id="update" value="Update"></td>
  </tr>
</table>

</form>