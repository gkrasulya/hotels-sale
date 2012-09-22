<?
login_required();

$id = $_GET['id'];

if (preg_match('/[^\d]+/', $id)) redirect(SITE_ADDR . 'account/');

$sql = "DELETE FROM hotels WHERE user_id=$user->id AND id=$id";
$result = mysql_query($sql);

if ($result) flash('Предложение удалено');

redirect(SITE_ADDR . 'account/');