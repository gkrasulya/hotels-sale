<h2>Редактирование фотографий предложения "<?= $acc_hotel->number ?>"</h2>

<?
require_once '_form_errors.php';
require_once '_flash.php';
?>

<p>
	Вы можете добавить к предложению дополнительные фотографии. Они будут отображаться на странице предложения в самом низу.
</p>

<div class="photos c" id="photos">
	<? if ($photos): ?>
		<? foreach ($photos as $photo): ?>
			<div class="add-image l">
				<img src="<?= SITE_ADDR ?>image.php?image=<?= SITE_ADDR ?>add_fotos/<?= $photo->big ?>&amp;width=150&amp;height=150&amp;cropration=1:1" alt="" />
				<a href="<?= SITE_ADDR ?>delete_add_photo/?id=<?= $photo->id ?>" title="" class="delete">x</a>
			</div>
		<? endforeach ?>
	<? else: ?>
		<p class="info" id="photoInfo">Сейчас фотографий нет</p>
	<? endif ?>
</div>

<form action="." method="POST" enctype="multipart/form-data" id="photoForm">
	<input id="photo" name="photo" type="file" />
	<a id="uploadLink" href="#" title="Загрузить">Загрузить</a>
</form>


<link href="<?= SITE_ADDR ?>/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?= SITE_ADDR ?>/uploadify/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?= SITE_ADDR ?>/uploadify/swfobject.js"></script>
<script type="text/javascript" src="<?= SITE_ADDR ?>/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	var firstSelect = true;

	var $photos = $('#photos'),
		$uploadLink = $('#uploadLink'),
		$photo = $('#photo');

	$photos.find('div.add-image').hover(function() {
		$(this).addClass('hover');
	}, function() {
		$(this).removeClass('hover');
	});

	$photos.find('a.delete').click(deletePhotoClick);


	$photo.uploadify({
		'uploader'  : '<?= SITE_ADDR ?>/uploadify/uploadify.swf',
		'script'    : '<?= SITE_ADDR ?>index.php?action=edit_offer_photos',
		'buttonImg': '<?= SITE_ADDR ?>/uploadify/button_image.png',
		'cancelImg' : '<?= SITE_ADDR ?>/uploadify/cancel.png',
		'fileExt'     : '*.jpg;*.jpeg;*.gif;*.png',
		'fileDesc'    : 'Файлы изображений',
		'width': 159,
		'height': 29,
		'rollover': true,
		'wmode': 'opaque',
		'multi': true,
		'scriptData': { s: '<?= "$user->email|$user->password" ?>', id: <?= $acc_hotel->id ?> },
		'fileDataName': 'photo',

		'onSelectOnce': function() {
			if (firstSelect) {
				$uploadLink.show();
				firstSelect = false;
			}
		},

		'onComplete': function(e, str, file, res) {
			res = res.split('|');

			var imgSrc = '<?= SITE_ADDR ?>image.php?width=150&height=150&cropration=1:1&image=<?= SITE_ADDR ?>add_fotos/' + res[0],
				$imgBlock = $('<div />'),
				imgHtml = '<img src="' + imgSrc + '" />',
				deleteHtml = '<a href="<?= SITE_ADDR ?>delete_add_photo/?id=' + res[1] + '" class="delete">x</a>'

			$imgBlock.addClass('add-image').addClass('l');
			$imgBlock.html(imgHtml + deleteHtml);

			$imgBlock.appendTo($photos);
			$imgBlock.hover(function() {
				$(this).addClass('hover');
			}, function() {
				$(this).removeClass('hover');
			});
			$imgBlock.find('a.delete').click(deletePhotoClick);

			$('#photoInfo').hide();
		}
	});

	$uploadLink.click(function() {
		$photo.uploadifyUpload();

		return false;
	});

	function deletePhotoClick() {
		var $self = $(this);
		if (confirm('Вы уверены?')) {
			$.post($self.attr('href'), function(res) {
				if (res == 'ok') {
					$self.parent().remove();

					alert($photos.find('div.add-image').length);
					if ($photos.find('div.add-image').length == 0) {
						if (! $('#photoInfo').length) {
							$photoInfo = $('<p class="info" id="photoInfo">Сейчас фотографий нет</p>').appendTo($photos);
						}
						$('#photoInfo').show();
					}
				}
			});
		}

		return false;
	}
});
</script>