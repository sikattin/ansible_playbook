<?
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
        $p_guild_id = 50293;

	$responseCode = SUCCESS;
	$emblem = array();
	$emblemInfo = array();
	$directories = server_directory($p_guild_id, GUILD_EMBLEM_MAIN_SEED, GUILD_EMBLEM_SUB_SEED); 

		$directoryPath = GUILD_EMBLEM_SAVE_PATH . $directories;

		$tmpPath = $directoryPath . '/temp_' . $p_guild_id . '.png';
		echo($tmpPath);

	exit;
?>
