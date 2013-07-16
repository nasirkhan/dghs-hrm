<?php

function createMySqlInsertString($request, $exception_field){
	$str_k="";
	$str_v="";
	foreach($request as $k=>$v){
		if(!in_array($k,$exception_field)){
			if(!empty($k)){
				$str_k.="$k,";
				$str_v.="'".mysql_real_escape_string(trim($v))."',";
			}
		}
	}
	$str=array();
	$str['k']=trim($str_k,',');
	$str['v']=trim($str_v,',');
	return $str;
}
?>
