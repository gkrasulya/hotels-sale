<?php
$random = rand(0,4);
$arr = array('���� ���� ���','��� ���� ����','������ ���� �����','���� ���� ������','������ ���� ������');
?>

<div id='form_div'>
	<form action='?demand=send' method="post" class="form" name="form" id="form"  >

		<p>
			<label title="name" for="name">�.�.�.*:</label><br />
			<input type="text" name="name" id="name" />
		</p>

		<p>
			<label title="email" for="email">E-mail*:</label><br />
			<input type="text" name="email" id="email" />
		</p>

		<p>
			<label title="email" for="email">������������ ��� ������* <br/> <span style='font-size:11px; font-style:italic;'>(���������, �����, �����, ������, ������ ������������):</label><br />
			<input type="text" name="object" id="object" />
		</p>

		<p>
			<label title="email" for="email">������������ ��� ������*:</label><br />
			<input type="text" name="country" id="country" />
		</p>

		<p>
			<label title="email" for="email">���� <span style='font-size:11px; font-style:italic; margin-left: 0px;'>(� ����):</label><br />
			<span class='little'>��</span> <input class='little' type="text" name="min_price" id="min_price" style='width: 100px'/>
			<span class='little'>��</span> <input class='little' type="text" name="max_price" id="max_price" style='width: 100px' />
		</p>

		<p>
			<label title="info" for="info">�������������� ���������� <br/>
				<span style='font-size:11px; font-style:italic;'>(����������� �������� ������� ��, ��� ��� ����������):</label><br />
			<textarea rows="5" cols="50" name="text" id="text"></textarea>
		</p>

		<p>
			<label title="info" for="info"><?php echo $arr[$random]; ?> �����*:</label><br />
			<input type='text' name="sum" id="sum" />
		</p>

		<p>
			<input type="submit" value="" class='submit' id='fDSubmit' />
			<input type='hidden' value='<?php echo $random; ?>' name='capa' id='capa'  />
		</p>

		<p>
			<span>����, ���������� *, ����������� ��� ����������.
		</p>

	</form>
</div>
<br />
<br />