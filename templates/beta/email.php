<?php
if (isset ($_POST['email_address']))
{
	file_put_contents('emails.txt',substr($_POST['email_address'],0,300) . "\r\n",FILE_APPEND);
}
else
{
	echo "Nothing to see here... :)";
}

?>