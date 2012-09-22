<?php
if (isset($_GET['t'])) {$t = $_GET['t'];}
if (isset($_GET['a'])) {$a = $_GET['a'];}
if (isset($_GET['do'])) {$do = $_GET['do'];}
if (isset($_GET['n'])) {$n = $_GET['n'];}
?>
<div id="wrapper">
<h1 style="margin-left:15px; color:#f47703;">Admin Panel</h1>
<!-- CONTENT START -->
        <div id="content">
            <div id="contentMain">
            	<?php
					
					if (!isset($t))
						{
							echo "<h2>Select type and action, please!</h2>";
						}
						
					else
						{
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// MAIN PAGE /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////					
						
							if ($t == "main")
								{
								
									echo "<h2>Главная страница</h2>";
								
									if (isset($do))
										{
											if (isset($_POST['title'])) {$title = $_POST['title'];}
											if (isset($_POST['text'])) {$text = $_POST['text'];}
											if (isset($_POST['meta_d'])) {$meta_d = $_POST['meta_d'];}
											if (isset($_POST['meta_k'])) {$meta_k = $_POST['meta_k'];}											
											
											$result = mysql_query("UPDATE main SET title='$title', text='$text', meta_d='$meta_d', meta_k='$meta_k' WHERE id='1'",$db);
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
										
											$result = mysql_query("SELECT * FROM main",$db);
											$myrow = mysql_fetch_array($result);
											
											echo "
											<br>
											<form method='post' id='form' action='?t=main&do'>
												<label>Заголовок</label>
												<input type='text' value='".$myrow['title']."' name='title'>
												<label>Ключевые слова (для поисковиков)</label>
												<input type='text' value='".$myrow['meta_k']."' name='meta_k'>
												<label>Краткое описание (для поисковиков)</label>
												<input type='text' value='".$myrow['meta_d']."' name='meta_d'>
												<label>Текст</label>
												<textarea name='text'>".$myrow['text']."</textarea>
												<input type='submit' value='ok'>
											</form>
																			
											";

								}
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// RANDOM VILLAS /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////					
						
							if ($t == "random")
								{
								
									echo "<h2>Вывод виллы в правой части</h2>";
								
									if (isset($do))
										{
											if (isset($_POST['hotels'])) {$hotels = $_POST['hotels'];}
											if (isset($_POST['random'])) {$random = $_POST['random'];}
											if ($random == 1) {$random = 1;} else {$random = 0;}
											$hotels = implode(",",$hotels);
											
											$result = mysql_query("UPDATE random SET hotels='$hotels', random='$random' WHERE id='1'",$db);
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
											
											$result_hot = mysql_query("SELECT * FROM hotels",$db);
											$myrow_hot = mysql_fetch_array($result_hot);
											
											echo "
											<br>
											<form method='post' id='form' action='?t=random&do'>
												<label>Выберите одну или несколько вилл</label>
												<select name='hotels[]' multiple='multiple'>
												";
											do 
												{
													if (strstr($myrow['hotels'],$myrow_hot['id'])) {$selected = "selected";} 
													else {$selected = "0";}
													echo "<option value=".$myrow_hot['id']." ".$selected.">".$myrow_hot['number']." - ".$myrow_hot['title']."</option>";
												}	
											while ($myrow_hot = mysql_fetch_array($result_hot));
												
											echo "
												</select><br><br>
												Показывать в случайном порядке
												<input type='checkbox' ".$rand." name='random' value=1><br><br>
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
								
							if ($t == "country")
								{

/////////////////////////////////////	ADDING COUNTRY ///////////////////////////////////////////						
								
									if ($a == "add")
										{
										
											echo "<h2>Добавление страны</h2>";
										
											if (isset($do))
												{
													if (isset($_POST['title'])) {$title = $_POST['title'];}
													$result = mysql_query("INSERT INTO countries (title) VALUES ('$title')",$db);
											
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
											echo "
											<br>
											<form method='post' id='form' action='?t=country&a=add&do'>
												<label>Название страны</label>
												<input type='text' name='title'><br>
												<input type='submit' value='ok'>
											</form>
																			
											";
										}
										
								
////////////////////////////////////// UPDATING COUNTRY //////////////////////////////////////////////										
										
									if ($a == "update")
										{
											if (!isset($n))
												{
													$result = mysql_query("SELECT * FROM countries",$db);
													$myrow = mysql_fetch_array($result);
													
													echo "<h2>Редактирование страны</h2>
													<form method='post' id='form'>
														<label>Выберите страну</label><br>";
												
													do
														{
															echo "
																<a href='?t=country&a=update&n=".$myrow['id']."' class='del'>".$myrow['title']."</a><br>
															";
														}
													while ($myrow = mysql_fetch_array($result));
													
													echo "<br><input type='submit' value='ok'>";
												
												}
											else
												{
													
										
													if (isset($do))
														{
															if (isset($_POST['title'])) {$title = $_POST['title'];}
															$result = mysql_query("UPDATE countries SET title = '$title' WHERE id='$n'",$db);
													
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
													
													$result = mysql_query("SELECT * FROM countries WHERE id='$n'",$db);
													$myrow = mysql_fetch_array($result);
														
													echo "
													<br>
													<form method='post' id='form' action='?t=country&a=update&n=".$myrow['id']."&do'>
														<label>Название страны</label>
														<input type='text' name='title' value='".$myrow['title']."'><br>
														<input type='submit' value='ok'>
													</form>
																					
													";
												}
										
										}
										
								
////////////////////////////////////// DELETING COUNTRY //////////////////////////////////////////////										
										
									if ($a == "delete")
										{
										
											echo "<h2>Удаление страны</h2>";
										
											if (isset($do))
												{
													$result = mysql_query("DELETE FROM countries WHERE id='$do'",$db);
													mysql_query("DELETE FROM regions WHERE country='$do'",$db);
													
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
											$result = mysql_query("SELECT * FROM countries",$db);
											$myrow = mysql_fetch_array($result);
											
											echo "<br>
												<label>Нажмите на страну, чтобы ее удалить</label><br><br>";
												
											do
												{
													echo "
														<a href='#' onClick=\"if(confirm('are you sure?')) {location.href='?t=country&a=delete&do=".$myrow['id']."'}\" class='del'>".$myrow['title']."</a><br>
													";
													
												}
											while ($myrow = mysql_fetch_array($result));
										}
								}
								
								
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// REGION MANAGEMENT /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////

								
							if ($t == "region")
								{
								
								
////////////////////////////////////// ADDING REGION //////////////////////////////////////////////								
								
									if ($a == "add")
										{
										
											echo "<h2>Добавление региона</h2>";
										
											if (isset($do))
												{
													if (isset($_POST['title'])) {$title = $_POST['title'];}
													if (isset($_POST['country'])) {$country = $_POST['country'];}
													
													$result = mysql_query("INSERT INTO regions (title,country) VALUES ('$title','$country')",$db);
											
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
												
											echo "
											<br>
											<form method='post' id='form' action='?t=region&a=add&do'>
												<label>Название региона</label>
												<input type='text' name='title'>
												<label>Страна</label>
												<select name='country'>";
												
												$result = mysql_query("SELECT * FROM countries",$db);
												$myrow = mysql_fetch_array($result);
												
												do
													{
														echo "<option value='".$myrow['id']."'>".$myrow['title']."</option>";
													}
												while ($myrow = mysql_fetch_array($result));
												
												
											echo "
												</select>
												<br>
												<input type='submit' value='ok'>
											</form>
																			
											";
										}
										
								
////////////////////////////////////// UPDATING REGION //////////////////////////////////////////////										
										
									if ($a == "update")
										{
											if (!isset($n))
												{
													$result = mysql_query("SELECT * FROM regions",$db);
													$myrow = mysql_fetch_array($result);
													
													echo "<h2>Редактирование региона</h2>
													<form method='post' id='form'>
														<label>Выберите регион</label><br>";
														
													do
														{
															echo "
																<a href='?t=region&a=update&n=".$myrow['id']."' class='del'>".$myrow['title']."</a><br>
															";
														}
													while ($myrow = mysql_fetch_array($result));
													
													echo "<br><input type='submit' value='ok'>";
												
												
												}
											else
												{
												
													echo "<h2>Редактирование региона</h2>";
												
													if (isset($do))
														{
															if (isset($_POST['title'])) {$title = $_POST['title'];}
															if (isset($_POST['country'])) {$country = $_POST['country'];}
															
															$result = mysql_query("UPDATE regions SET title='$title',country='$country' WHERE id='$n'",$db);
													
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
														
													$result = mysql_query("SELECT * FROM regions WHERE id='$n'",$db);
													$myrow = mysql_fetch_array($result);	
													
													echo "
													<br>
													<form method='post' id='form' action='?t=region&a=update&n=".$n."&do'>
														<label>Название региона</label>
														<input type='text' name='title' value='".$myrow['title']."'>
														<label>Страна</label>
														<select name='country'>";
														
														$result2 = mysql_query("SELECT * FROM countries",$db);
														$myrow2 = mysql_fetch_array($result2);
														
														do
															{
																echo "<option value='".$myrow2['id']."'";
																if ($myrow['country'] == $myrow2['id']) {echo " selected";}
																echo ">".$myrow2['title']."</option>";
																echo "country: ".$myrow['country']." and id: ".$myrow2['id'];
															}
														while ($myrow2 = mysql_fetch_array($result2));
														
														
													echo "
														</select>
														<br>
														<input type='submit' value='ok'>
													</form>
																					
													";

												
												}
										
										}
										
								
////////////////////////////////////// DELETING REGION //////////////////////////////////////////////										
										
									if ($a == "delete")
										{
										
											echo "<h2>Удаление региона</h2>";
										
											if (isset($do))
												{
													$result = mysql_query("DELETE FROM regions WHERE id='$do'",$db);
													
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
											$result = mysql_query("SELECT * FROM regions",$db);
											$myrow = mysql_fetch_array($result);
											
											echo "<br>
												<label>Нажмите на регион, чтобы его удалить</label><br><br>";
												
											do
												{
													echo "
														<a href='#' onClick=\"if(confirm('are you sure?')) {location.href='?t=region&a=delete&do=".$myrow['id']."'}\" class='del'>".$myrow['title']."</a><br>
													";
													
												}
											while ($myrow = mysql_fetch_array($result));
										
										}
								}
								
								
						
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// HOTEL MANAGEMENT /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////								
								
							if ($t == "hotel")
								{
								
////////////////////////////////////// HOTEL //////////////////////////////////////////////								
								
									if ($a == "add")
										{
										
											echo "<h2>Добавление виллы</h2>";
										
											if (isset($do))
												{
													if (isset($_POST['name'])) {$name = $_POST['name'];}
													if (isset($_POST['text'])) {$text = $_POST['text'];}
													if (isset($_POST['desc'])) {$desc = $_POST['desc'];}
													if (isset($_POST['number'])) {$number = $_POST['number'];}
													if (isset($_POST['town'])) {$town = $_POST['town'];}
													if (isset($_POST['price'])) {$price = $_POST['price'];}
													if (isset($_POST['price_s'])) {$price_c = $_POST['price_s'];}
													if (isset($_POST['region'])) {$region = $_POST['region'];}
													if (isset($_POST['country'])) {$country = $_POST['country'];}
													if (isset($_POST['foto'])) {$foto = $_POST['foto'];}
													
													require_once("blocks/foto.php");
													
													$result = mysql_query("INSERT INTO hotels 
													(title,town,text,price,number,region,country,descr,foto,price_s,tosend) VALUES ('$name','$town','$text','$price','$number','$region','$country','$desc','$foto_id','$price_s','1')",$db);
											
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
												
											echo "<br>
											<form method='post' id='form' enctype='multipart/form-data' action='?t=hotel&a=add&do'>
												<label>Название виллы</label>
												<input type='text' name='name'>
												<label>Номер</label>
												<input type='text' name='number'>
												<label>Город</label>
												<input type='text' name='town'>
												<label>Цена</label>
												<input type='text' name='price'>
												<label>Цена (без пробелов)</label>
												<input type='text' name='price_s'>
												<label>Краткое описание</label>
												<textarea name='desc'></textarea>
												<label>Подробное описание</label>
												<textarea name='text'></textarea>
												<label>Фотография</label>
												<input type='file' name='foto'>
												<label>Страна</label>
												<select name='country'>
												";
												
												$result = mysql_query("SELECT * FROM countries",$db);
												$myrow = mysql_fetch_array($result);
													do
														{
															echo "<option value='".$myrow['id']."'>".$myrow['title']."</option>\n";
														}	
													while ($myrow = mysql_fetch_array($result));
												
												echo "
												</select>
												<label>Регион</label>
												<select name='region'>
												";
												
												$result = mysql_query("SELECT * FROM countries",$db);
												$myrow = mysql_fetch_array($result);
												echo "<option value='0'> Без региона </option>";
													do
														{
															echo "<option disabled> --- ".$myrow['title']." --- </option>\n";
															$result2 = mysql_query("SELECT * FROM regions WHERE country='$myrow[id]'",$db);
															if (mysql_num_rows($result2) > 0)
																{
																	$myrow2 = mysql_fetch_array($result2);
																	do
																		{
																			echo "<option value=".$myrow2['id'].">".$myrow2['title']."</option>\n";
																		}
																	while ($myrow2 = mysql_fetch_array($result2));
																}
														}
													while ($myrow = mysql_fetch_array($result));
												
											echo "
												</select><br>
												<input type='submit' value='ok'>
											</form>
																			
											";
										}

								
////////////////////////////////////// UPDATING HOTEL //////////////////////////////////////////////
										
									if ($a == "update")
										{
											if (!isset($n))
												{
													$result = mysql_query("SELECT * FROM hotels",$db);
													$myrow = mysql_fetch_array($result);
													
													echo "<h2>Редактирование виллы</h2>
													<form method='post' id='form'>
														<label>Выберите гостиницу</label><br>";
														
													do
														{
															echo "
																<a href='?t=hotel&a=update&n=".$myrow['id']."' class='del'>".$myrow['number']." - ".$myrow['title']."</a><br>
															";
														}
													while ($myrow = mysql_fetch_array($result));
													
													echo "<br><input type='submit' value='ok'>";
												
												}
											else
												{
												
												
										
													echo "<h2>Редактирование гостиницы</h2>";
												
													if (isset($do))
														{
															if (isset($_POST['title'])) {$name = $_POST['title'];}
															if (isset($_POST['text'])) {$text = $_POST['text'];}
															if (isset($_POST['desc'])) {$desc = $_POST['desc'];}
															if (isset($_POST['number'])) {$number = $_POST['number'];}
															if (isset($_POST['town'])) {$town = $_POST['town'];}
															if (isset($_POST['price'])) {$price = $_POST['price'];}
															if (isset($_POST['price_s'])) {$price_s = $_POST['price_s'];}
															if (isset($_POST['region'])) {$region = $_POST['region'];}
															if (isset($_POST['foto'])) {$foto = $_POST['foto'];}
															if (isset($_POST['country'])) {$country = $_POST['country'];}
													
															if ($foto != "") {require_once("blocks/foto.php");}
															if ($foto_id) {$foto_id = ",foto='$foto_id'";} else {$foto_id = "";}
															
															
															$result = mysql_query("UPDATE hotels SET title='$name' ,town='$town',text='$text',price='$price',number='$number',region='$region',descr='$desc',country='$country',price_s='$price_s'".$foto_id." WHERE id='$n'",$db);
													
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
														
													$result = mysql_query("SELECT * FROM hotels WHERE id='$n'",$db);
													$myrow = mysql_fetch_array($result);
														
													echo "<br>
													<form method='post' id='form' enctype='multipart/form-data' action='?t=hotel&a=update&n=".$myrow['id']."&do'>
														<label>Название виллы</label>
														<input type='text' name='title' value='".$myrow['title']."'>
														<label>Номер</label>
														<input type='text' name='number' value='".$myrow['number']."'>
														<label>Город</label>
														<input type='text' name='town' value='".$myrow['town']."'>
														<label>Цена</label>
														<input type='text' name='price' value='".$myrow['price']."'>
														<label>Цена (без пробелов)</label>
														<input type='text' name='price_s' value='".$myrow['price_s']."'>
														<label>Краткое описание</label>
														<textarea name='desc'>".$myrow['descr']."</textarea>
														<label>Подробное описание</label>
														<textarea name='text'>".$myrow['text']."</textarea>
														<label>Фотография</label>
														<input type='file' name='foto'>
														<label>Страна</label>
														<select name='country'>
														";
														
														$result = mysql_query("SELECT * FROM countries",$db);
														$myrow = mysql_fetch_array($result);
															do
																{
																	$result_abc = mysql_query("SELECT country FROM hotels WHERE id='$n'",$db);
																	$myrow_abc = mysql_fetch_array($result_abc);
																	echo "<option value='".$myrow['id']."'";
																	if ($myrow['id'] == $myrow_abc['country'])
																		{
																			echo "selected";
																		}
																	echo ">".$myrow['title']."</option>\n";
																}	
															while ($myrow = mysql_fetch_array($result));
														
														echo "
														</select>
														<label>Местонахождение</label>
														<select name='region'>
														";
														
														$result = mysql_query("SELECT * FROM countries",$db);
														$myrow = mysql_fetch_array($result);
														echo "<option value='0'> Без региона </option>";
														$result_abc = mysql_query("SELECT region FROM hotels WHERE id='$n'",$db);
														$myrow_abc = mysql_fetch_array($result_abc);
														do
																{
																	echo "<option disabled> --- ".$myrow['title']." --- </option>\n";
																	$result2 = mysql_query("SELECT * FROM regions WHERE country='$myrow[id]'",$db);
																	if (mysql_num_rows($result2) > 0)
																		{
																			$myrow2 = mysql_fetch_array($result2);
																			do
																				{
																					echo "<option value=".$myrow2['id']."";
																					if ($myrow2['id'] == $myrow_abc['region'])
																						{
																							echo " selected";
																						}
																					echo ">".$myrow2['title']."</option>\n";
																				}
																			while ($myrow2 = mysql_fetch_array($result2));
																		}
																}
															while ($myrow = mysql_fetch_array($result));
														
													echo "
														</select><br>
														<input type='submit' value='ok'>
													</form>
																					
													";
												
												}
										
										}
										
								
////////////////////////////////////// DELETING HOTEL //////////////////////////////////////////////

										
									if ($a == "delete")
										{
										
											echo "<h2>Удаление Гостиницы</h2>";
										
											if (isset($do))
												{
													$result = mysql_query("SELECT foto FROM hotels WHERE id='$do'",$db);
													$myrow = mysql_fetch_array($result);
													$id = $myrow['foto'];
													$result_foto = mysql_query("SELECT * FROM fotos WHERE id='$id'",$db);
													$myrow_foto = mysql_fetch_array($result_foto);
													if (file_exists("../fotos/".$myrow_foto['img_pre']) && file_exists("../fotos/".$myrow_foto['img_big']))
														{
															$a = unlink("../fotos/".$myrow_foto['img_pre']);
															$b = unlink("../fotos/".$myrow_foto['img_big']);
														}
													$result_foto = mysql_query("DELETE FROM fotos WHERE id='$id'",$db);
													$result = mysql_query("DELETE FROM hotels WHERE id='$do'",$db);
													
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
											$result = mysql_query("SELECT id,title,number FROM hotels",$db);
											$myrow = mysql_fetch_array($result);
											
											echo "<br>
												<label>Нажмите на гостиницу, чтобы ее удалить</label><br><br>";
												
											do
												{
													echo "
														<a href='#' onClick=\"if(confirm('are you sure?')) {location.href='?t=hotel&a=delete&do=".$myrow['id']."'}\" class='del'>".$myrow['number']." - ".$myrow['title']."</a><br>
													";
													
												}
											while ($myrow = mysql_fetch_array($result));
										
										}
								}
						}
		
		
#####################################################################################################3
##################################################3333 MAIL ###########################################
######################################################################################################

							if ($t == 'mail')
								{
									$result = mysql_query("SELECT * FROM emailers",$db);
									$myrow = mysql_fetch_array($result);
									
									if (isset($_GET['act'])) 
										{
$new = '';
											$result_hotels = mysql_query("SELECT * FROM hotels WHERE tosend='1'",$db);
											$hotels = mysql_fetch_array($result_hotels);
											
											do
												{
$new .= $hotels['number']." - ".$hotels['title']."\n
Цена: ".$hotels['price'].", Комнат: ".$hotels['rooms']." \n
".$hotels['descr']."\n
подробнее: http://hotels-sale.ru/?h=".$hotels['id']."\n\n\n";
													
													mysql_query("UPDATE hotels SET tosend='0' WHERE id = '".$hotels['id']."' ",$db);
												}
											while ($hotels = mysql_fetch_array($result_hotels));
											
											do
												{
													$to = $myrow['email'];
													$subject = "Hotels-sale.ru, Villas: Новые предложения";
													$body = "Добрый день, ".$myrow['name']."! Новые предложения: \n\n
".$new."Посмотреть новые предложения Вы можете здесь: http://hotels-sale.ru/villas/?new";
													
													$mail = mail($to,$subject,$body,"Content-type:text/plain; Charset=windows-1251 \r\n"."From: news@hotels-sale.ru \r\n");
												
												}
											while ($myrow = mysql_fetch_array($result));
											
													
											if ($mail)
												{
													echo "<h2>Письма отправлены!</h2>";
												}
											else
												{
													echo "<h2>Что-то пошло не так!</h2>";
												}
										
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
													echo "<a href='#' onClick=\"if(confirm('are you sure?')) {location.href='?t=mail&delete&do=".$myrow['id']."'}\" class='del'>".$myrow['name']." - ".$myrow['email']."</a><br>
															";
															
														}
													while ($myrow = mysql_fetch_array($result));
												}
										
										}
									
									
									if (!isset($_GET['act']) && !isset($_GET['delete']))
										{
											echo "<h2>Рассылка</h2>
												<a href='?t=mail&act'>Разослать</a><br/><br/>
												
												Список рассыкли:
												<ul style='margin-left:30px; list-style: decimal;'>";
											do 
												{
													echo "<li>".$myrow['name'].": <a href='mailto:".$myrow['email']."'>".$myrow['email']."</a></li>";
												}
											while ($myrow = mysql_fetch_array($result));
											
											echo "</ul>";
										}
								}
							
///////////////////////////////////////////////////////////////////////////////////////////////////////////							
/////////////////////////////////////////////////// ADD PHOTOS TO HOTEL /////////////////////////////////////////////	
///////////////////////////////////////////////////////////////////////////////////////////////////////////	

							if ($t == 'photos')
								{
									if ($a == 'add')
										{
											if (!isset($do))
												{
													$result = mysql_query("SELECT id,title,number FROM hotels ORDER BY country",$db);
													$hotels = mysql_fetch_array($result);
													echo "
														<form action='?t=photos&a=add&do' method='post' enctype='multipart/form-data'>
															<p>
																<label>Фотография:</label><br/>
																<input type='file' name='foto' />
															</p>
															<p>
																<label>Гостиница</label><br/>
																<select name='hotel_id' style='width:200px;'>
													";
													do 
														{
															echo "<option value='".$hotels['id']."'>".$hotels['number']." - ".$hotels['title']."</option>";
														}
													while ($hotels = mysql_fetch_array($result));
													echo "
																</select>
															</p>
															<p>
																<input type='submit' value='ok'/>
															</p>
														</form>
													";
												}
											else
												{
													if (isset($_POST['foto'])) { $foto = $_POST['foto']; }
													if (isset($_POST['hotel_id'])) { $hotel_id = $_POST['hotel_id']; }
													require_once('blocks/add_foto.php');
													echo "Все ок!";
												
												}
										
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
				?>
            </div>
        </div>
<!-- CONTENT END -->

<!-- NAVIGATION START -->  
       <?php require_once("navigation.php"); ?>
<!-- NAVIGATION END -->          
</div>

