<?php
echo "<form action=links_search.php method=POST style=\"margin: 0px;\">
      Поиск: Что искать? - - - - - - - - - - - - - - - - - В разделе? - - - - - - - - В категории?<br><input name=what_search type=text size=51 maxlength=255 style=\"width:260px;\" value=\"\">
      <select style=\"width:140px;\" name=where_search><option value=\"\"></option><option value=\"\">Все разделы</option><option value=Модерация>Модерация</option><option>-------------</option><option value=Старые>Проверенные давно</option><option value=Новые>Добавленные недавно</option><option value=Хорошие>Хорошие</option><option value=Плохие>Плохие</option><option value=Недоступные>Недоступные</option><option value=Скрытые>Скрытые</option><option>-------------</option><option value=Корзина>Корзина</option><option value=Блэк-лист>Блэк-лист</option></select>
      <select style=\"width:200px;\" name=categories_search><option value=\"\"></option><option value=\"\">Все категории</option>";
	  for($i=0;$i<count($categories_array);$i++) { $row = explode("|", $categories_array[$i]); echo "<option>"."$row[1]"."</option>"; }
      echo "</select>";
echo "<input style=\"width:60px;\" type=submit name=search value=\"Найти\"></form>";
?>