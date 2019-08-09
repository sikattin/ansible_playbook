<?
	function getRandomValue(){
		/*	unsigned int
		$nRandom1 = rand(0, 4294967295 / 2);
		$nRandom2 = rand(0, 4294967295 / 2);
		$nMax = 4294967295;
		*/
		/* signed int */
		$nRandom1 = rand(0, 2147483647);
		$nRandom2 = 0;
		$nMax     = 2147483647;
		$nRandom  = $nRandom1 + $nRandom2;

		if ($nRandom > $nMax) {
			return 0;
		} else {
			return $nRandom;
		}
	}
	
	function getPeriodTitle($m_period){
		$m_nBasis    = mktime(0, 0, 0, 7, 1, 2006);
		$m_nNowTime  = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$m_nTitleDay = (($m_nNowTime - $m_nBasis) / 86400) + $m_period;
		return $m_nTitleDay;
	}

	function print_r2($p_data){
		echo "<pre>";
		print_r($p_data);
		echo "</pre>";
	}

	function js_alert($p_message){
		echo "<script>alert('{$p_message}');</script>";
	}

	function js_submit($p_url,$p_params){
		$form_name = 'frmAtSb'.rand(0,1000);
		$output_text = "<form id='{$form_name}' name='{$form_name}' method='post' action='{$p_url}'>";
		
		foreach($p_params as $key => $value){
			$output_text .= "<input type='hidden' id='{$key}' name='{$key}' value='{$value}'>";
		}
		
		$output_text .= "</form><script>document.getElementById('{$form_name}').submit();</script>";
		echo $output_text;
	}
?>