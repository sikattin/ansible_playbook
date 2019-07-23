<?
	function arad_socket_send($p_sv,$p_input){
		global $SOCK_IP;
		global $SOCK_PORT;

		$m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if(!$m_socket){
			return -1;
		}
	
		$m_conn = socket_connect($m_socket, $SOCK_IP[$p_sv], $SOCK_PORT[$p_sv]);

		if(!$m_conn){
			return -1;
		}else{
			$m_res = socket_write($m_socket, $p_input);
			$debug_message = socket_strerror(socket_last_error());
			//echo "<script>alert('ip:{$SOCK_IP[$p_sv]}\\nport:{$SOCK_PORT[$p_sv]}\\nsocket_data:{$p_input}\\nsocket_error:{$debug_message}');</script>";
}
	
		socket_close($m_socket);
	
		return $m_res;
	}
?>
