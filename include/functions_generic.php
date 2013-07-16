<?php

/**
 * Create a Mysql Insert String form $_POST values
 * @param type $request
 * @param type $exception_field
 * @return type
 */
function createMySqlInsertString($request, $exception_field) {
    $str_k = "";
    $str_v = "";
    foreach ($request as $k => $v) {
        if (!in_array($k, $exception_field)) {
            if (!empty($k)) {
                $str_k.="$k,";
                $str_v.="'" . mysql_real_escape_string(trim($v)) . "',";
            }
        }
    }
    $str = array();
    $str['k'] = trim($str_k, ',');
    $str['v'] = trim($str_v, ',');
    return $str;
}

/**
 * Get the list of values of a Enum Column
 * @param string $table_name
 * @param string $column_name
 * @return type
 */
function getEnumColumnValues($table_name, $column_name) {
    $table_name = "old_tbl_staff_organization";
    $column_name = "govt_quarter";
//    echo "<select name=\"$column_name\">";
    $result = mysql_query("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'") or die(mysql_error());

    $row = mysql_fetch_array($result);
    $enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE']) - 6))));

    foreach ($enumList as $value)
//        echo "<option value=\"$value\">$value</option>";

    return $enumList;
}

?>
