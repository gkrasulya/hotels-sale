<?php
if (isset($myrow['number']))
	{
		$number = $myrow['number'];
		$vis = "";
	}
else
	{
		$number = $_GET['number'];
		$vis = "style='display:inline;'";
		$result = mysql_query("SELECT title FROM hotels WHERE number='$number'",$db);
		$myrow = mysql_fetch_array($result);
	}
?>

<form action='?form=send' method="post" class="form" name="form" id="form" <?php echo $vis; ?> >
<input type="hidden" value="<?php echo $number; ?>" name="number" />
<p>
<label title="text" for="title">��������*:</label><br />
<input type="text" name="title" id="title" value="<?php echo $myrow['title']; ?>" />
</p>
<p>
<label title="name" for="name">�.�.�.*:</label><br />
<input type="text" name="name" id="name" />
</p>
<p>
<label title="email" for="email">E-mail*:</label><br />
<input type="text" name="email" id="email" />
</p>
<p>
<label title="info" for="info">�������������� ����������:</label><br />
<textarea rows="5" cols="50" name="info" id="info"></textarea>
</p>
<p>
<input type="submit" value="���������" class='submit' />
<p>
<span>����, ���������� *, ����������� ��� ����������.</span>
</form>
