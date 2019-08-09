<?php
        //configurations
        error_reporting(E_ERROR | E_WARNING | E_PARSE);

        $cf_function = "/d_fighter/core/function";
        $allowed = array("application/zip");

        //file include
        include_once("$cf_function/common/save_file.func.php");

        //const
	const SUCCESS = 1;		// 正常処理
        const IMAGE_NOT_EXISTS = -5;    // 添付画像なし
        const IMAGE_TOO_BIG = -1;       // 画像のサイズ制限
        const IMAGE_INVALID = -3;       // 画像の拡張子エラー
	const CONVERT_FAIL_INPUT_INVALID = -102;	// 入力ファイル指定されず

	define('GUILD_EMBLEM_PARAMETER', 'guild_emblem');
	define('GUILD_EMBLEM_MAX_SIZE', 102400);
	define('GUILD_EMBLEM_EXTENSION', 'png');
	define('GUILD_EMBLEM_SAVE_PATH', '/d_fighter/guildem.arad.jp/data/guild/emblem/');
	define('GUILD_EMBLEM_MAIN_SEED', 32);
	define('GUILD_EMBLEM_SUB_SEED', 251);
	define('GUILD_EMBLEM_CONVERTER', '/usr/local/bin/conv2img');
	define('GUILD_EMBLEM_WIDTH', 28);
	define('GUILD_EMBLEM_HEIGHT', 28);

        //get parameters
        $p_guild_id = $_POST['guild_id'];

	$responseCode = SUCCESS;
	$emblem = array();
	$emblemInfo = array();
	$directories = server_directory($p_guild_id, GUILD_EMBLEM_MAIN_SEED, GUILD_EMBLEM_SUB_SEED); 

	if ($responseCode === SUCCESS && isset($_FILES[GUILD_EMBLEM_PARAMETER])===true ){
		$emblem = $_FILES[GUILD_EMBLEM_PARAMETER];
		$emblemInfo = pathinfo($emblem['name']) ;
	}else{
		$responseCode = IMAGE_NOT_EXISTS;
	}

	if ($responseCode === SUCCESS && $emblem['size'] > GUILD_EMBLEM_MAX_SIZE  ){
		$responseCode = IMAGE_TOO_BIG;
	}

	if ($responseCode === SUCCESS && (isset($emblemInfo['extension'])!==true || GUILD_EMBLEM_EXTENSION !== strtolower($emblemInfo['extension'])  ) ){
		$responseCode = IMAGE_INVALID;
	}

	if ($responseCode === SUCCESS && in_array($emblem['type'], $allowed)==false ){
		$responseCode = IMAGE_INVALID;
	}

	if ($responseCode === SUCCESS){
		$directoryPath = GUILD_EMBLEM_SAVE_PATH . $directories;

		if (false === file_exists($directoryPath)){
			$folderExists = mkdir($directoryPath, 0777, true);
		}else{
			$folderExists = true;
		}

		if (false === $folderExists){
			$responseCode = CONVERT_FAIL_INPUT_INVALID;
		}
	}

	if ($responseCode === SUCCESS){

		$tmpPath = $directoryPath . '/temp_' . $p_guild_id . '.png';
		
		if (false === move_uploaded_file($emblem['tmp_name'], $tmpPath)){
			$fileExists = false;
		}else{
			$fileExists = true;
			chmod($tmpPath, 0666);
		}

		if (false === $fileExists){
			$responseCode = CONVERT_FAIL_INPUT_INVALID;
		}
	}

	if ($responseCode === SUCCESS){
		$pngPath = $directoryPath . '/' . $p_guild_id . '.png';
		$imgPath = $directoryPath . '/' . $p_guild_id . '.img';

		$scriptCall = implode(
			' ',
			array(
				GUILD_EMBLEM_CONVERTER,
				'-i', $tmpPath,
				'-o', $imgPath,
				'-p', $pngPath,
				'-w', GUILD_EMBLEM_WIDTH,
				'-h', GUILD_EMBLEM_HEIGHT
			)
		);

		exec($scriptCall, $outputTemp, $returnVar);
		if (0 != $returnVar){
			$responseCode = (intval($returnVar) * -1 ) - 100;
			// var_dump($scriptCall);

		}

	}

	echo($responseCode);

	exit;
?>
