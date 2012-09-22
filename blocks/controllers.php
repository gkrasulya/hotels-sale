<?               if (!isset($h)
                	&& ! isset($r)
                	&& ! isset($c)
                	&& ! isset($about)
                	&& ! isset($qwe)
                	&& ! isset($form)
                	&& ! isset($new)
                	&& ! isset($getmail)
                	&& ! isset($search)
                	&& ! isset($test)
                	&& ! isset($demand)
                	&& ! isset($slug)
                	&& ! isset($adv)
                	&& ! isset($page_name)
                	&& ! isset($sitemap)
                	&& ! isset($text_name)
                	&& ! isset($action)) {
                		$new = true;
                		require_once "controllers/new_hotels.php"; // INDEX PAGE
                }
                
        #### common

        if (isset($action)) {
        	require_once "controllers/$action.php";
        }
        
        if (isset($page_name)) {
        	require_once "controllers/$page_name.php";
        }
				
				##############################################
				
				if (isset($sitemap)) {
					require_once 'controllers/sitemap.php';
				}
				
				##############################################
				
				if (isset($adv)) {
					require_once "controllers/adv.php";
				}
				
				if (isset($getmail)) {
					require_once "controllers/getmail.php"; // GET MAIL
				}
				
				##############################################
		
				if (isset($about)) {
					require_once "controllers/about.php"; // ABOUT PAGE
				}
				
				##############################################
				
		        if (isset($h) || isset($_GET['slug'])) {
		        	require_once "controllers/hotel.php"; // SHOW HOTEL
		        }
		        
				##############################################
				
				if (isset($new)) {
					require_once "controllers/new_hotels.php"; // NEW HOTELS
				}
				
				##############################################
				
				if (isset($r)) {
					require_once "controllers/region.php"; // HOTELS OF REGION
				}
				
				##############################################
					

				if (isset($qwe)) {
					require_once "controllers/country.php"; // HOTELS OF COUNTRY
				}
				
				##############################################
				
				if (isset($search)) {
					require_once "controllers/search.php"; // SEARCH HOTELS
				}
			
				###############################################
				
				if (isset($form)) {
					require_once "controllers/form.php";
				}
	
				###############################################
	
				if (isset($demand)) {
					require_once "controllers/demand.php";
				}
	
				###############################################
	
				if (isset($text_name)) {
					$text_path = "texts/{$text_name}.php";
					#require_once $text_path;
				}