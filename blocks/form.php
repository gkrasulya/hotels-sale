<?php
if (isset($_GET['number']))
	{
		$number = $_GET['number'];
		$vis = "";
		$result = mysql_query("SELECT title FROM hotels WHERE number='$number'",$db);
		$myrow = mysql_fetch_array($result);
	}
else
	{
		$number = $myrow['number'];
		$vis = "style='display: none;'";
	}
	
$random = rand(0,4);
$arr = array('���� ���� ���','��� ���� ����','������ ���� �����','���� ���� ������','������ ���� ������');
?>

<div id='form_div' <?php echo $vis; ?>>
<form action='<?= SITE_ADDR ?>?form=send' method="post" class="form" name="form" id="form"  style="float: left; position: relative;" >
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
	<label title="phone" for="phone">�������*:</label><br />
	<input type="text" name="phone" id="phone" />
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
<label title="info" for="info">
	<img src="/captcha<?=$random?>.png" alt="" /><br/>
	������� ��� � ��������:
</label><br />
<input type='text' name="sum" id="sum" />
</p>
<p>
<input type='hidden' value='<?php echo $random; ?>' name='capa' id='capa'  />
<input type="submit" value="" class='submit' id='fDSubmit' />
</p>
<p>
<span>����, ���������� *, ����������� ��� ����������.</span>
</p>
</form>
</div>
<br />
<br />