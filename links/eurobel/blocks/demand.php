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
<label title="email" for="email">������������ ��� ������* <br/> (���������, �����, �����, ������, ������ ������������):</label><br />
<input type="text" name="country" id="country" />
</p>
<p>
<label title="email" for="email">������������ ��� ������*:</label><br />
<input type="text" name="country" id="country" />
</p>
<p>
<label title="email" for="email">���� (� ����):</label><br />
�� <input type="text" name="min_pprice" id="min_price" style='width: 100px'/>
�� <input type="text" name="max_pprice" id="max_price" style='width: 100px' />
</p>
<p>
<label title="info" for="info">�������������� ���������� <br/>(����������� �������� ������� ��, ��� ��� ����������):</label><br />
<textarea rows="5" cols="50" name="text" id="text"></textarea>
</p>
<p>
<label title="info" for="info"><?php echo $arr[$random]; ?> �����*:</label><br />
<input type='text' name="sum" id="sum" />
</p>
<p>
<input type="submit" value="���������" class='submit' />
<input type='hidden' value='<?php echo $random; ?>' name='capa' id='capa'  />
</p>
<p>
<span>����, ���������� *, ����������� ��� ����������.</span>
</p>
</form>
</div>
<br />
<br />