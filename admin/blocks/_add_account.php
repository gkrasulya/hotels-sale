<h2>����� �������</h2>

<?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	foreach ($_POST as $kw => $val) $$kw = addslashes($val);

	$error = false;

	$md5_password = md5($password);

	$data = array(
		'active' => ((int)$months != 0),
		'email' => "'$email'",
		'password' => "'$md5_password'",
		'type' => "'$type'",
		'expiration_date' => "DATE_ADD(NOW(), INTERVAL $months MONTH)"
	);

	$sql = "INSERT INTO users\n";
	$sql .= " (\n\t" . implode(array_keys($data), ",\n\t") . "\n)\n";
	$sql .= " VALUES (\n\t" . implode(array_values($data), "	,\n\t") . "\n)";

	if (trim($data['email']) == '' || trim($data['password']) == '') {
		$error = '�� ��� ���� ���������';
	}

	if (! $error) {
		$result = mysql_query($sql);

		if ($result) {
			echo "<h4 class='flash'>������� ��������!</h4>";
		} else  {
			echo mysql_error();
			echo "<h4 class='error'>�� ����������!</h4>";
		}	
	} else {
		echo "<h4 class='error'>$error</h4>";
	}
		
}

$agency_periods = array(
	1 => '1 �����',
	2 => '2 ������',
	3 => '3 ������',
	4 => '4 ������',
	6 => '6 �������',
	12 => '1 ���',
	18 => '1 ��� 6 �������',
	24 => '2 ����'
);
	
?>

<br />

<form method='POST' id='form' enctype='multipart/form-data' action='?t=accounts&amp;a=add'>
	<div class="form-row">
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="<?= $_POST['email'] ?>" />
	</div>

	<div class="form-row">
		<label for="password">������</label>
		<input type="text" name="password" id="password" />
	</div>

	<div class="form-row">
		<label for="type">��� ��������</label>
		<select name="type" id="type">
			<option value="agency">��������</option>
			<option value="user">������������</option>
		</select>
	</div>

	<div class="form-row">
		<label for="months">�� ����</label>
		<select name="months" id="months">
			<? foreach ($agency_periods as $i => $name): ?>
				<option value="<?= $i ?>"><?= $name ?></option>
			<? endforeach ?>
		</select>
	</div>
	
	<div class="form-row">
		<button type="submit">���������</button>
	</div>
</form>