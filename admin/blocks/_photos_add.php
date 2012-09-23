<?
if (!isset($do)):
		$result = mysql_query("SELECT id,title,number FROM hotels ORDER BY country",$db);
		$hotels = mysql_fetch_array($result);
?>

	<form action="?t=photos&amp;a=add&amp;do" method="POST" enctype="multipart/form-data">
		<p>
			<label>Фотография:</label><br/>
			<input type="file" name="foto" />
		</p>

		<p>
			<label>Гостиница</label><br/>
			<input type="text" name="search" id="search" placeholder="Поиск объекта" style="margin: 5px 0"><br>
			<select name="hotel_id" style="float: left; width:200px;" multiple size=10 id="hotel_id">
				<? do { ?>
					<option value="<?= $hotels['id'] ?>"><?= $hotels['number'] . ' - ' . $hotels['title'] ?></option>
				<? } while ($hotels = mysql_fetch_array($result)); ?>
			</select>
			<div id="searchResult" style="white-space: nowrap; overflow: hidden; width: 457px; height: 170px; border: 1px solid #ccc; margin-left: 5px; float: left; display: none;"></div>

			<div style="clear: both;"&nbsp;></div>
		</p>
		<p>
			<input type="submit" value="ok"/>
		</p>
	</form>

	<script type="text/javascript">
		(function($) {
			var $search = $('#search'),
				$searchResult = $('#searchResult'),
				$select = $('#hotel_id'),
				$options = $select.find('option'),
				timeout = null;

			$options.each(function() {
				var $this = $(this);
				$this.data('title', $this.html().toLowerCase());
			});

			$searchResult.click(function(e) {
				if (e.target.nodeName.toLowerCase() == 'a') {
					var i = $(e.target).data('i');
					$select[0].selectedIndex = i;
					$searchResult.html('');
					$searchResult.hide();

					return false;
				}
			});

			$search.keydown(function() {
				if (timeout) {
					clearTimeout(timeout);
				}
				timeout = setTimeout(function() {
					var s = $search[0].value.toLowerCase(),
						titles = [],
						html = '';

					$options.each(function(i) {
						var $o = $(this),
							title = $o.data('title')

						if (title.indexOf(s) >= 0) {
							titles.push({
								title: title,
								i: i
							});
						}
					});

					$.each(titles, function(i, title) {
						html += '<a href="#" data-i=' + title.i + '>' + title.title + '</a><br>';
					});

					$searchResult.show().html(html);
				}, 200);
			});
		})(jQuery);
	</script>

<? else:
	if (isset($_POST['foto'])) {
		$foto = $_POST['foto'];
	}
	if (isset($_POST['hotel_id'])) {
		$hotel_id = $_POST['hotel_id'];
	}
	require_once 'blocks/add_foto.php';
	echo 'Все ок!';
endif ?>