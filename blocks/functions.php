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
	$text = str_replace('�', '&euro;', $text);
	return Markdown($text);
}

$confs = array(
	array('�', 'a'),
	array('�', 'b'),
	array('�', 'v'),
	array('�', 'g'),
	array('�', 'd'),
	array('�', 'e'),
	array('�', 'e'),
	array('�', 'zh'),
	array('�', 'z'),
	array('�', 'i'),
	array('�', 'y'),
	array('�', 'k'),
	array('�', 'l'),
	array('�', 'm'),
	array('�', 'n'),
	array('�', 'o'),
	array('�', 'p'),
	array('�', 'r'),
	array('�', 's'),
	array('�', 't'),
	array('�', 'u'),
	array('�', 'f'),
	array('�', 'h'),
	array('�', 'c'),
	array('�', 'ch'),
	array('�', 'sh'),
	array('�', 'sch'),
	array('�', 'y'),
	array('�', 'y'),
	array('�', 'y'),
	array('�', 'e'),
	array('�', 'yu'),
	array('�', 'ya'),
	array('�', 'a'),
	array('�', 'b'),
	array('�', 'v'),
	array('�', 'g'),
	array('�', 'd'),
	array('�', 'e'),
	array('�', 'e'),
	array('�', 'zh'),
	array('�', 'z'),
	array('�', 'i'),
	array('�', 'y'),
	array('�', 'k'),
	array('�', 'l'),
	array('�', 'm'),
	array('�', 'n'),
	array('�', 'o'),
	array('�', 'p'),
	array('�', 'r'),
	array('�', 's'),
	array('�', 't'),
	array('�', 'u'),
	array('�', 'f'),
	array('�', 'h'),
	array('�', 'c'),
	array('�', 'ch'),
	array('�', 'sh'),
	array('�', 'sch'),
	array('�', 'y'),
	array('�', 'y'),
	array('�', 'y'),
	array('�', 'e'),
	array('�', 'yu'),
	array('�', 'ya')
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
	array('period'=>1, 'price'=>800, 'name'=>'1 �����, 820 ������ (&euro;'.(rub2euro(820)).'*)'),
	array('period'=>2, 'price'=>1500, 'name'=>'2 ������, 1500 ������ (&euro;'.(rub2euro(1500)).'*)'),
	array('period'=>3, 'price'=>2500, 'name'=>'3 ������, 2500 ������ (&euro;'.(rub2euro(2500)).'*)'),
	array('period'=>4, 'price'=>3000, 'name'=>'4 ������, 3000 ������ (&euro;'.(rub2euro(3000)).'*)'),
	array('period'=>5, 'price'=>3500, 'name'=>'5 �������, 3500 ������ (&euro;'.(rub2euro(3500)).'*)'),
	array('period'=>6, 'price'=>4000, 'name'=>'��� ����, 4000 ������ (&euro;'.(rub2euro(4000)).'*)'),
	array('period'=>'infinite', 'price'=>6000, 'name'=>'��������������**, 6000 ������ (&euro;'.(rub2euro(6000)).'*)')
);

$agency_periods = array(
	array('period'=>1, 'name'=>'1 �����'),
	array('period'=>2, 'name'=>'2 ������'),
	array('period'=>3, 'name'=>'3 ������'),
	array('period'=>4, 'name'=>'4 ������'),
	array('period'=>5, 'name'=>'5 �������'),
	array('period'=>6, 'name'=>'��� ����')
);