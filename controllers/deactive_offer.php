<?
login_required();

$id = $_GET['id'];

if (preg_match('/[^\d]+/', $id)) redirect(SITE_ADDR . 'account/');

$sql = "UPDATE hotels SET active = 0 WHERE user_id=$user->id AND id=$id";
$result = mysql_query($sql);

if ($result) flash('Предложение деактивировано');

redirect(SITE_ADDR . 'account/');