<?php 

$confs = array(
	array('а', 'a'),
	array('б', 'b'),
	array('в', 'v'),
	array('г', 'g'),
	array('д', 'd'),
	array('е', 'e'),
	array('ё', 'e'),
	array('ж', 'zh'),
	array('з', 'z'),
	array('и', 'i'),
	array('й', 'y'),
	array('к', 'k'),
	array('л', 'l'),
	array('м', 'm'),
	array('н', 'n'),
	array('о', 'o'),
	array('п', 'p'),
	array('р', 'r'),
	array('с', 's'),
	array('т', 't'),
	array('у', 'u'),
	array('ф', 'f'),
	array('х', 'h'),
	array('ц', 'c'),
	array('ч', 'ch'),
	array('ш', 'sh'),
	array('щ', 'sch'),
	array('ъ', 'y'),
	array('ы', 'y'),
	array('ь', 'y'),
	array('э', 'e'),
	array('ю', 'yu'),
	array('я', 'ya')
);

function create_slug($title) {
	global $confs;

	if ($title == NULL) {
		return '';
	} else {
		$slug = $title;
	}

	$slug = trim(mb_strtolower($title, 'UTF-8'));

	foreach ($confs as $conf) {
		$slug = preg_replace("/" . $conf[0] . "/", $conf[1], $slug);
	}
	
	$slug = preg_replace('/\s+/', ' ', $slug);
	$slug = preg_replace("/[^a-zA-Z0-9\-\s]/", '', $slug);
	$slug = trim($slug);
	$slug = str_replace(' ', '-', $slug);

		
	return $slug;
}

echo create_slug('Привет, как дела     вот то то ??');

?>