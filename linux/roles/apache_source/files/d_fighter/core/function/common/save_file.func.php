<?php
	function create_directory($path){
		if(!is_dir($the_path)){
			$a='';
			foreach(explode("/",$path) AS $k){
				$a.=$k."/";
				if(!is_dir($a)) mkdir($a, 0777);
			}
		}
	}

	function server_directory($p_guild_id,$p_gm_h1,$p_gm_h2){
		$d1 = $p_guild_id % $p_gm_h1;
		$d2 = floor($p_guild_id / $p_gm_h1) % $p_gm_h2;
		$d3 = floor( floor($p_guild_id / $p_gm_h1) / $p_gm_h2);
		$directory = $d1."/".$d2."/".$d3;
		
		return $directory;
	}
?>
