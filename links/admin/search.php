<?php
echo "<form action=links_search.php method=POST style=\"margin: 0px;\">
      �����: ��� ������? - - - - - - - - - - - - - - - - - � �������? - - - - - - - - � ���������?<br><input name=what_search type=text size=51 maxlength=255 style=\"width:260px;\" value=\"\">
      <select style=\"width:140px;\" name=where_search><option value=\"\"></option><option value=\"\">��� �������</option><option value=���������>���������</option><option>-------------</option><option value=������>����������� �����</option><option value=�����>����������� �������</option><option value=�������>�������</option><option value=������>������</option><option value=�����������>�����������</option><option value=�������>�������</option><option>-------------</option><option value=�������>�������</option><option value=����-����>����-����</option></select>
      <select style=\"width:200px;\" name=categories_search><option value=\"\"></option><option value=\"\">��� ���������</option>";
	  for($i=0;$i<count($categories_array);$i++) { $row = explode("|", $categories_array[$i]); echo "<option>"."$row[1]"."</option>"; }
      echo "</select>";
echo "<input style=\"width:60px;\" type=submit name=search value=\"�����\"></form>";
?>