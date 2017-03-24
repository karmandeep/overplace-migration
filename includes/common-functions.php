<?php

	//Common Functions
	function generateClientPW($plain, $salt = "", $ignoreconfig = false) {
		global $CONFIG;
	
		if (( $CONFIG["NOMD5"] && !$ignoreconfig )) {
			$pw = encrypt( $plain );
		}
		else {
			if (!$salt) {
				$seeds = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#!%()#!%()#!%()";
				$seeds_count = strlen( $seeds ) - 1;
				$i = 0;
	
				while ($i < 5) {
					$salt .= $seeds[rand( 0, $seeds_count )];
					++$i;
				}
			}
	
			$pw = md5( $salt . html_entity_decode( $plain ) ) . ":" . $salt;
		}
	
		return $pw;
	}

	



?>