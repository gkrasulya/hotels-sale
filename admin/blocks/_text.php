<?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$title = addslashes($_POST['title']);
	$text = addslashes($_POST['text']);
	$meta_d = addslashes($_POST['meta_d']);
	$meta_k = addslashes($_POST['meta_k']);

	$update_sql = "
		UPDATE main
		SET title='$title', text='$text', meta_d='$meta_d', meta_k='$meta_k'
		WHERE slug='$slug'
	";
	
	$update_result = mysql_query($update_sql);
		echo $update_result ? "<h4>Все сделано!</h4>" : "<h4>Не получилось!</h4>";
	}

$slug = addslashes($_GET['slug']);
$text_sql = "SELECT * FROM main WHERE slug='$slug'";
$text_result = mysql_query($text_sql);
$text = mysql_fetch_array($text_result);
?>

<h2>Редактирование текста</h2>

<br />
<form method="POST" id="form" action="?t=text&amp;slug=<?= $text['slug'] ?>">
	<div class="form-row">
		<label>Заголовок</label>
		<input type="text" value="<?= $text['title'] ?>" name="title">
	</div>
	<? if ($slug == 'main'): ?>
		<div class="form-row">
			<label>Ключевые слова (для поисковиков)</label>
			<textarea name="meta_k"><?= $text['meta_k'] ?></textarea>
		</div>

		<div class="form-row">
			<label>Краткое описание (для поисковиков)</label>
			<textarea name="meta_d"><?= $text['meta_d'] ?></textarea>
		</div>
	<? endif ?>

	<div class="form-row">
		<label>Текст</label>
		<textarea name="text"><?= $text['text'] ?></textarea>
	</div>

	<div class="form-row">
		<button type="submit">Сохранить</button>
	</div>
</form>