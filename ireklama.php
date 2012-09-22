<?php

	$LFM['code'] = "MSJI7vSAes"; // Произвольный набор символов, НЕ МЕНЯТЬ!
	$LFM['hash'] = "70a526cae4817e94cd3a4771cfe6d463"; // Выполняет роль пароля. НЕ МЕНЯТЬ!
	$LFM['cl'] = ""; // класс ссылок, который будет вставлен. В данном случае будет <a href=some_url class=add>text</a>
	$LFM['delimiter'] = " "; // Символ, которым будут разделяться разные ссылки. В данном случае будет <a href=some_url class=add>text</a> | <a href=some_url class=add>text</a> | <a href=some_url class=add>text</a> и т.д.
    $LFM['temp_dir'] = realpath('.')."/tmp"; // Каталог для хранения временных файлов. 

    $LFM['num_blocks'] = 1; 

    //-- Checking temp dir 
    if (strpos(@$_SERVER['REQUEST_URI'],'ireklama.php')) {

        if (isset($_POST['code']) && $_POST['code'] == $LFM['code'] &&
            isset($_POST['hash']) && $_POST['hash'] == $LFM['hash'] 
            && $fh = @fopen($LFM['temp_dir']."/data", "w")
        ) {

            if (get_magic_quotes_gpc()) {
                fputs($fh, stripslashes(@$_POST['data']));            
            } else {
                fputs($fh, @$_POST['data']);            
            }
            
            fclose($fh);
            print "Ok Uploaded";
        } else {

            if (!$fh = @fopen($LFM['temp_dir']."/test", "w")) {
                die('Cannot open dir '.$LFM['temp_dir'].' for write');
            } else {
                fclose($fh);
                unlink($LFM['temp_dir']."/test");
                print "Ok<adv_part>";
            }
        }
    }
    
    function get_links($parts = 1) {
        
        global $LFM;

        if (!is_readable($LFM['temp_dir']."/data")) {
            return;
        }

        $data = file_get_contents($LFM['temp_dir']."/data");
        $data = unserialize($data);
        
        if (!is_array($data)) {
            return;
        }

        $url = $_SERVER['REQUEST_URI'];
        if (isset($data[$url])) {
            $links = $data[$url];
        } else {
            $links = $data[":all:"];
        }
        
        shuffle($links['links']);
        $size = ceil(sizeof($links['links'])/$parts);
        for ($i=0; $i<$parts; $i++) {
            
            $part = array_slice($links['links'], $i*$size, $size);
            $code = implode($part, $LFM['delimiter']);
            if ($LFM['cl']) {
                $code = str_replace('%class%', 'class="'.$LFM['cl'].'"', $code);
            } else {
                $code = str_replace(' %class%', '', $code);
            }

            $code .= $links['default'];
            $codes[$i] = $code;
        }

        return $codes;
    }

    $codes = get_links();
    print $codes[0];
?>