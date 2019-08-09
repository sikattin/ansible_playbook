<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
</head>
<body>
<?
        //configurations
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $cf_function = "/d_fighter/core/function";
        $gm_sample_path = "/d_fighter/guildem.arad.jp/data/sample";
        $gm_save_path = "/d_fighter/guildem.arad.jp/data/guild/emblem";
        $allowed = array("image/bmp","image/x-bmp","image/png","image/x-png");
        $allowed_ext = array("bmp","png");
        $allowed_filesize = 102400;
        $allowed_server = array("cain","diregie","tester","release");
        $gm_h1 = 32;
        $gm_h2 = 251;
        $pr_error = 0;
		$SOCK_IP = array('cain'=>'172.16.23.204','diregie'=>'172.16.23.205','tester'=>'119.235.225.14','release'=>'172.16.23.249');
        $SOCK_PORT = array('cain'=>30401,'diregie'=>30402,'tester'=>30300,'release'=>30401);

        //file include
        include_once("$cf_function/common/save_file.func.php");
        include_once("$cf_function/common/send_packet.func.php");

        //get parameters
        $p_guild_emblem = $_POST['guild_emblem'];
        $p_sv = $_POST['sv'];
        $p_guild_id = $_POST['guild_id'];
        $p_sample = $_POST['sample'];
        $p_return_url = $_POST['return_url'];
        $p_hash_key = $_POST['hash_key'];

        //check hash value
        if(md5("^^".$p_guild_id."?".$p_return_url."!".$p_sv)!=$p_hash_key){
                $pr_error = 5;
        }

        //parameter validation
        if(!$p_guild_id || !$p_sample){
                $pr_error = 6;
        }
        if(!in_array($p_sv, $allowed_server)){
                $pr_error = 8;
        }

        if($pr_error>0){
                echo "<script>alert('[E-G-M-{$pr_error}]ご指定のURLはアクセスできません。);</script>";
                echo("
                        <form name=frm method=post action='http://{$p_return_url}'>
                        </form>
                        <script>frm.submit();</script>
                ");
                exit;
        }

        if($p_sv=="release"){
                $gm_save_path = "/d_fighter/guildem.arad.jp/data/guild/emblem_release";
        }

        //processing
        $directory = server_directory($p_guild_id,$gm_h1,$gm_h2);
        create_directory("{$gm_save_path}/{$directory}");

        if($p_sample < 99){
                if($p_sample < 10){
                        $p_sample = '0'.$p_sample;
                }

                if(copy("{$gm_sample_path}/gmark{$p_sample}.png","{$gm_save_path}/{$directory}/{$p_guild_id}.png") ){
                        @chmod("$gm_save_path/$directory/{$p_guild_id}.png",0666);
                }else{
                        $pr_error = 1;
                }

                if(copy("{$gm_sample_path}/gmark{$p_sample}.img","{$gm_save_path}/{$directory}/{$p_guild_id}.img") ){
                        @chmod("$gm_save_path/$directory/{$p_guild_id}.img",0666);
                }else{
                        $pr_error = 2;
                }
        }else{
                $file_name = $_FILES['guild_emblem']['name'];
                $file_size = $_FILES['guild_emblem']['size'];
                $file_name_temp = $_FILES['guild_emblem']['tmp_name'];
                $file_type = $_FILES['guild_emblem']['type'];
                $file_name = $p_guild_id . '_user' . strrchr(strtolower($file_name),'.');
                $file_extension = substr(strrchr($file_name, '.'),1);

                if( in_array($file_type, $allowed) && in_array($file_extension, $allowed_ext) && ($file_size < $allowed_filesize)  ){
                        umask(0000);
                        move_uploaded_file($file_name_temp,"$gm_save_path/$directory/$file_name");
                        @chmod ("$gm_save_path/$directory/$file_name", 0666);
                        $temp = exec("/usr/local/bin/conv2img -i $gm_save_path/$directory/$file_name -o {$gm_save_path}/{$directory}/{$p_guild_id}.img  -p {$gm_save_path}/{$directory}/{$p_guild_id}.png -w 19 -h 13", $temp, $return_code);

                        if($return_code>0){
                           switch($return_code){
                                case 1 : $pr_error = 10; break;
                                case 2 : $pr_error = 11; break;
                                case 3 : $pr_error = 12; break;
                                case 4 : $pr_error = 13; break;
                                case 5 : $pr_error = 14; break;
                                case 6 : $pr_error = 15; break;
                                case 7 : $pr_error = 16; break;
                                case 8 : $pr_error = 17; break;
                                case 9 : $pr_error = 18; break;
                                case 10 : $pr_error = 19; break;
                                case 11 : $pr_error = 20; break;
                           }
                        }
                }else{
                        $pr_error = 4;
                }
        }
        $i1 = 20020;
        $i2 = 14; 
        $i3 = 0;
        $i4 = 0;
        $i5 = $p_guild_id;
        $input = pack("vvvII",$i1,$i2,$i3,$i4,$i5);

        if(!arad_socket_send($p_sv,$input)){
                $pr_error = 7;
        }

        if($p_return_url!=""){
                echo("
                        <form id='frm' name='frm' method='post' action='{$p_return_url}'>
                        <input type='hidden' name='return_code' value='{$pr_error}'>
                        <input type='hidden' name='sample' value='{$p_sample}'>
                        </form>
                        <script>document.getElementById('frm').submit();</script>
                ");
        }
?>
</body>
</html>
<?
exit;
?>
