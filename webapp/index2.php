<?php
	
	getSQLStr("select DISTINCT bid from 01u_0info_history where mobile= or uname=? or personid=? or telphone=?", array($conData['srhKey'], $conData['srhKey'], $conData['srhKey'], $conData['srhKey']));




	function getSQLStr(str,array){

	}
?>