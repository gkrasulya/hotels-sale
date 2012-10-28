<?php
$t = isset($_GET['t']) ? $_GET['t'] : null;
$a = isset($_GET['a']) ? $_GET['a'] : null;
$do = isset($_GET['do']) ? $_GET['do'] : null;
$n = isset($_GET['n']) ? $_GET['n'] : null;
$b = isset($_GET['b']) ? $_GET['b'] : null;
$banner_stats = isset($_GET['banner_stats']) ? $_GET['banner_stats'] : null;

?>
<div id="wrapper">
<h1 style="font-weight: normal">Панель Администратора</h1>
<!-- CONTENT START -->
        <div id="content">
            <div id="contentMain">
            	<?php

					
					if (!isset($t) && !isset($banner_stats))
						{
							echo "<h2>Select type and action, please!</h2>";
						}
						
					else
						{
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// MAIN PAGE /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

							if (isset($banner_stats)) {
								require_once('parts/banners_stats.php');
							}
						
							if ($t == "text") {
								require '_text.php';
							}
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// RANDOM HOTELS /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////					
						
							if ($t == "random")
								{
								
									echo "<h2>Вывод гостиниц в правой части</h2>";
								
									if (isset($do))
										{
											if (isset($_POST['hotels'])) {$hotels = $_POST['hotels'];}
											if (isset($_POST['random'])) {$random = $_POST['random'];}
											if (isset($_POST['levoe'])) {$levoe = $_POST['levoe'];}
											if (isset($_POST['third'])) {$third = $_POST['third'];}
											if (isset($_POST['number'])) {$number = $_POST['number'];}
											if ($random == 1) {$random = 1;} else {$random = 0;}
											if ($third == 1) {$third = 1;} else {$third = 0;}
											$hotels = implode(",",$hotels);
											
											$result = mysql_query("UPDATE random SET hotels='$hotels', random='$random', levoe='$levoe', third='$third', number='$number' WHERE id='1'",$db);
											if ($result) 
												{
													echo "
														<h4>Все сделано!</h4>";
												}
											else 
												{
													echo "
														<h4>Не получилось!</h4>";
												}
												
										}
										
											$result = mysql_query("SELECT * FROM random",$db);
											$myrow = mysql_fetch_array($result);
											if ($myrow['random'] == 1) {$rand = 'checked';} else {$rand = '';}
											if ($myrow['levoe'] == 1) {$levoe = 'checked';} else {$levoe = '';}
											if ($myrow['third'] == 1) {$third = 'checked';} else {$third = '';}
											
											$result_c = mysql_query("SELECT * FROM countries",$db);
											$country = mysql_fetch_array($result_c);
											
											$result_hot = mysql_query("SELECT * FROM hotels",$db);
											$myrow_hot = mysql_fetch_array($result_hot);
											
											echo "
											<br>
											<form method='post' id='form' action='?t=random&do'>
											<label>Выберите одну или несколько гостиниц (via ctrl):</label>
											<select multiple='multiple' name='hotels[]' style='width: 450px; height: 200px;'>";
											do {
												$result_h = mysql_query("SELECT * FROM hotels WHERE country='$country[id]'",$db);
												$hotel = mysql_fetch_array($result_h);
												echo "
												<option disabled='disabled'></option>
												<option disabled='disabled'></option>
												<option disabled='disabled'><<".$country['title'].">></option>
												<option disabled='disabled'></option>
												";
												do {
													echo "<option value='".$hotel['id']."'>".$hotel['number']." - ".$hotel['title']."</option>";
												} while ($hotel = mysql_fetch_array($result_h));
											} while ($country = mysql_fetch_array($result_c));
											echo "
											</select><br><br>
											Random hotels:
											<input type='checkbox' ".$rand." name='random' value=1><br><br>
											Number of random hotels:
											<input type='text' size='3' name='number' value='".$myrow['number']."' /><br/><br/>
											Показывать в случайном порядке (selected hotels):
											<input type='checkbox' ".$third." name='third' value=1><br><br>
											Show offers?:
											<input type='checkbox' ".$levoe." name='levoe' value=1><br><br>
											<input type='submit' value='ok'>
											</form>
											";

								}
						
												
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// ABOUT COMPANY /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////

							if ($t == "about")
								{
										
									echo "<h2>О компании</h2>";
								
									if (isset($do))
										{

											if (isset($_POST['visible'])) {$visible = $_POST['visible'];}
											if (isset($_POST['text'])) {$text = $_POST['text'];}
											if (isset($_POST['title'])) {$title = $_POST['title'];}
											if (isset($_POST['main'])) {$main = $_POST['main'];}
											
											if ($visible != 1) {$visible = 0;}
											
											$result = mysql_query("UPDATE about SET title='$title', text='$text', visible='$visible', main='$main' WHERE id='1'",$db);
											if ($result) 
												{
													echo "
														<h4>Все сделано!</h4>";
												}
											else 
												{
													echo "
														<h4>Не получилось!</h4>";
												}
										}										
										
											$result = mysql_query("SELECT * FROM about",$db);
											$myrow = mysql_fetch_array($result);
											
											if ($myrow['visible'] == 1) {$ch = "checked='checked'";} else {$ch = "";}
											if ($myrow['main'] == 1) {$ma = "checked";} else {$ma = "";}
											
											echo "
											<br>
											<form method='post' id='form' action='?t=about&do'>
												<label>Заголовок</label>
												<input type='text' value='".$myrow['title']."' name='title'>
												<label>Текст</label>
												<textarea name='text'>".$myrow['text']."</textarea><br><br>
												Отображать ссылку \"Главная\" &nbsp;
												<input type='checkbox' name='visible' value=1 ".$ch."><br><br>
												Отображать ссылку \"О компании\" &nbsp;
												<input type='checkbox' name='main' value=1 ".$ch."><br>
												<input type='submit' value='ok'>
											</form>
											";


							
								}
	
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// SETTINGS  /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////
								
							if ($t == "password")
								{
								
									echo "<h2>Настройки</h2>";
								
									if (isset($do))
										{
										
											if (isset($_POST['login'])) {$login = $_POST['login'];}
											if (isset($_POST['password'])) {$password = $_POST['password'];}
											if (isset($_POST['email'])) {$email = $_POST['email'];}
											
											$result = mysql_query("UPDATE admin SET login='$login',password='$password',email='$email' WHERE id='1'",$db);
											
											if ($result) 
												{
													echo "
														<h4>Все сделано!</h4>";
												}
											else 
												{
													echo "
														<h4>Не получилось!</h4>";
												}
										}										
											$result = mysql_query("SELECT * FROM admin",$db);
											$myrow = mysql_fetch_array($result);
											
											echo "
											<br>
											<p>Текущий логин: <strong>".$myrow['login']."</strong></p>
											<p>и пароль: <strong>".$myrow['password']."</strong></p>
											<form method='post' id='form' action='?t=password&do'>
												<label>Новый логин</label>
												<input type='text' name='login' value='".$myrow['login']."'>
												<label>Новый пароль</label>
												<input type='text' name='password' value='".$myrow['password']."'>
												<label>E-mail (который отображается на сайте)</label>
												<input type='text' name='email' value='".$myrow['email']."'>
												<br>
												<input type='submit' value='ok'>
											</form><br>
											
											<form method='post' id='form'>
											</form>
											";

								}
								
								
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// COUNTRY MANAGEMENT /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////								
							if ($t == "country") {
								require_once "_{$a}_{$t}.php";
							}							
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// REGION MANAGEMENT /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////
							if ($t == "region") {
								require_once "_{$a}_{$t}.php";
							}
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// HOTEL MANAGEMENT /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////								
								
							if ($t == "hotel") {

								$hotel_cols = array(
									'title',
									'town',
									'text',
									'text_html',
									'rooms',
									'price',
									'number',
									'region',
									'country',
									'descr',
									'descr_html',
									'foto',
									'price_s',
									'tosend',
									'slug',
									'client_email',
									'forward'
								);

								if ($a == "add") {
									require_once '_add_hotel.php';
								}
										
								if ($a == "update") {
									require_once '_update_hotel.php';
								}
										
								if ($a == "delete") {
									require_once '_delete_hotel.php';
								}

							}
						}


						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// AGENCY USERS /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////			


if ($t == 'accounts') {
	if (! isset($a) || $a == 'delete' || $a == 'update' || $a == 'edit_info') {
		require_once '_list_account.php';
	}

	if ($a == 'add') {
		require_once '_add_account.php';
	}
}

						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// MAIL /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

							if ($t == 'mail') {
									$emailers = get_records("SELECT * FROM emailers");
									
									if (isset($_GET['act'])) {
										require_once '_mail_send.php';
									}

									if (isset($_GET['list'])) {
										require_once '_mail_list.php';										
									}

									if (isset($_GET['delivery'])) {
										require_once '_mail_delivery_detail.php';										
									}
										
									if (isset($_GET['delete']))
										{
											if (isset($_GET['do']))
												{
													$do = $_GET['do'];
													$result = mysql_query("DELETE FROM emailers WHERE id='$do'",$db);
													
													if ($result)
														{
															echo "<h2>Все ок!</h2>";
														}
													else
														{
															echo "<h2>Не получилось!</h2>";
														}
												}
											else
												{
											$result = mysql_query("SELECT id,name,email FROM emailers",$db);
											$myrow = mysql_fetch_array($result);
											
											echo "<br>
												<label>Нажмите на адресата, чтобы его удалить</label><br><br>";
												
											do
												{
													echo "<a href='#' onClick=\"if(confirm('Вы уверены?')) {location.href='?t=mail&delete&do=".$myrow['id']."'}\" class='del'>".$myrow['name']." - ".$myrow['email']."</a><br>
															";
															
														}
													while ($myrow = mysql_fetch_array($result));
												}
										
										}
									
									if (!isset($_GET['act']) && !isset($_GET['delete']) && !isset($_GET['list'])
											&& !isset($_GET['delivery'])) { 
										require_once '_mail_main.php';
									}
								}
								
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// ADD PHOTOS TO HOTEL /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

							if ($t == 'photos')
								{
									if ($a == 'add')
										{
											require_once '_photos_add.php';
										}
										
									if ($a == 'delete')
										{
											if (isset($do))
												{
													$result = mysql_query("DELETE FROM add_fotos WHERE id = '$do'",$db);
													if ($result)
														{
															echo "<h2>Все ок!</h2>";
														}
													else
														{
															echo "<h2>Не получилось!</h2>";
														}
												}
											else
												{
													echo "<h2>Выберите фото, которое хотите удалить</h2>";
													$result = mysql_query("SELECT id,title,number FROM hotels ORDER BY country",$db);
													$hotels = mysql_fetch_array($result);
													do
														{
															$result2 = mysql_query("SELECT * FROM add_fotos WHERE hotel_id='$hotels[id]'",$db);
															if (mysql_num_rows($result2) > 0)
																{
																	$photos = mysql_fetch_array($result2);
																	echo "<h4>".$hotels['number']." - ".$hotels['title']."</h4>";
																	do
																		{
																			echo "
																				<a href='?t=photos&a=delete&do=".$photos['id']."' onclick=\"return (confirm('Are you sure?') ? true : false)\" style='border:none;'>
																					<img src='../add_fotos/".$hotels['id']."/".$photos['small']."' style='border:none;' />
																				</a>";
																		}
																	while ($photos = mysql_fetch_array($result2));
																}
														}
													while ($hotels = mysql_fetch_array($result));
												}
										}
								}
								
								if ($t == 'banners') {
									
									require_once('parts/banners.php');
								
								}
					
				?>
            </div>
        </div>
<!-- CONTENT END -->

<!-- NAVIGATION START -->  
       <?php require_once("navigation.php"); ?>
<!-- NAVIGATION END -->          
</div>

