<?
login_required();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$id = $_GET['id'];

	if (preg_match('/[^\d]+/', $id)) die('error');

	$sql = "
		DELETE a.* FROM hotels h, add_fotos a
		WHERE
			a.id = $id
			AND a.hotel_id = h.id
			AND h.user_id = $user->id
	";

	$result = mysql_query($sql);

	if ($result) die('ok');
	else die('error');
}