<?

if (isset($do)) {
	
	$position = $_POST["position"];
	$identificator = $_POST["identificator"];
	$good = true;
	for ($i=1; $i<count($position); $i++) {
		$p = $position[$i];
		$id = $identificator[$i];
		$result = mysql_query("UPDATE countries SET position='$p' WHERE id='$id'",$db);
		if (!result) { $good = false; }
	}
	if ($good) {
		echo "<h4>Все сделано!</h4>";
		}
	else {
		echo "<h4>Не получилось!</h4>";
		}
}

echo "<h2>Сортировка предложений</h2>";

$countryResult = mysql_query("SELECT * FROM countries ORDER BY position",$db);
$country = mysql_fetch_array($countryResult);

echo "<form action='?t=country&a=order&do' method='post' id='orderForm'>";
do {
	echo "
	<p>
		<input style='margin-top: 5px;' type='text' name='position[]' value='".$country["position"]."' size='3' />
		<input type='hidden' name='identificator[]' value='".$country["id"]."' size='3' />
		 &nbsp;&nbsp;<label><img src='../new_images/flags/".$country['flag']."' alt='".$country["title"]."' /> &nbsp;<strong>".$country["title"]."</strong></label>
	</p>";
} while ($country = mysql_fetch_array($countryResult));
echo "<p style='margin-top: 10px;'><input type='submit' value='refresh' /></form>";