<?
	//php environment setting
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	set_include_path('/d_fighter/core/lib/pear'.PATH_SEPARATOR.get_include_path());
	set_include_path('/d_fighter/core'.PATH_SEPARATOR.get_include_path());

	//const
	define(CORE_PATH,"/d_fighter/core/");

	//include
	require_once(CORE_PATH."function".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."send_packet.func.php");
	require_once(CORE_PATH."function".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."save_file.func.php");
	require_once(CORE_PATH."function".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."common.func.php");
	require_once("DB.php");

	//db settrings for real server
	$dsn = array(
		'arad_cain' => array('phptype'=>'mysql','hostspec'=>'172.16.23.224','database'=>'arad_cain','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_cain_2nd' => array('phptype'=>'mysql','hostspec'=>'172.16.23.226','database'=>'arad_cain_2nd','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_diregie' => array('phptype'=>'mysql','hostspec'=>'172.16.23.228','database'=>'arad_diregie','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_diregie_2nd' => array('phptype'=>'mysql','hostspec'=>'172.16.23.230','database'=>'arad_diregie_2nd','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_first' => array('phptype'=>'mysql','hostspec'=>'172.16.23.222','database'=>'arad_first','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_first_2nd' => array('phptype'=>'mysql','hostspec'=>'172.16.23.223','database'=>'arad_first_2nd','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_login' => array('phptype'=>'mysql','hostspec'=>'172.16.23.232','database'=>'arad_login','username'=>'dnf_game','password'=>'n_arad_game'),
		'd_guild' => array('phptype'=>'mysql','hostspec'=>'172.16.23.234','database'=>'d_guild','username'=>'dnf_game','password'=>'n_arad_game'),
		'd_arad' => array('phptype'=>'mysql','hostspec'=>'172.16.23.233','database'=>'d_arad','username'=>'dnf_game','password'=>'n_arad_game'),
		'd_arad_m' => array('phptype'=>'mysql','hostspec'=>'172.16.23.232','database'=>'d_arad','username'=>'dnf_game','password'=>'n_arad_game'),
		'd_arad_s' => array('phptype'=>'mysql','hostspec'=>'172.16.23.233','database'=>'d_arad','username'=>'dnf_game','password'=>'n_arad_game'),
		'arad_main_web' => "mssql://arad_main_web:df34gF36hT23?@218.40.61.204/arad_main_web"
	);

	//db settrings for release server
	$dsn_release = array(
		'arad_cain' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_dev','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_cain_2nd' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_dev','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_diregie' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_dev','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_diregie_2nd' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_dev','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_first' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_dev','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_first_2nd' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_dev','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_login' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'dnf_login','username'=>'dnf_game','password'=>'dnf^game'),
		'd_guild' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'d_guild','username'=>'dnf_game','password'=>'dnf^game'),
		'd_arad' => array('phptype'=>'mysql','hostspec'=>'172.16.23.248','database'=>'d_arad','username'=>'dnf_game','password'=>'dnf^game'),
		'arad_main_web' => "mssql://arad_main_web:df34gF36hT23?@218.40.61.204/arad_main_web"
	);

	//game server info
	$SERVER_EN = array(1=>"cain",2=>"diregie",99=>"tester");
	$SERVER_JP = array(1=>"カイン",2=>"ディレジエ",99=>"テスト");
	$SERVER_NO = array('cain'=>1,'diregie'=>2,'tester'=>99);

	//socket info
	$SOCK_IP = array('cain'=>'172.16.23.204','diregie'=>'172.16.23.205','tester'=>'119.235.225.14','release'=>'172.16.23.249');
	$SOCK_PORT = array('cain'=>30401,'diregie'=>30402,'tester'=>30300,'release'=>30401);
?>