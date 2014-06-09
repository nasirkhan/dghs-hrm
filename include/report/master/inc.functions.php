<?php

function getTableFieldNamesFrmMultipleTables($tableNames) {

  global $dbname;
  $fieldNames = array();

  $i = 0;
  foreach ($tableNames as $tableName) {
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tableName'";
    //echo $sql;
    $r = mysql_query($sql) or die(mysql_error() . "<b>Query:</b><br>$sql<br>");
    if (mysql_num_rows($r)) {
      $a = mysql_fetch_rowsarr($r);

      foreach ($a as $fieldName) {
        $fieldNames[$i++] = $fieldName['COLUMN_NAME'];
      }
    }
  }

  return $fieldNames;
}

function getSexGroupedCount($additionalWheres = " AND s.sex_name in('Male','Female')") {
  global $tableName;
  global $SQLWhereStatement;
  global $group_by;
  global $orderByParam;

  if (strlen(trim($group_by))) {

    $sql = "SELECT $group_by,s.sex_name, count(*) as total FROM $tableName $SQLWhereStatement $additionalWheres GROUP BY $group_by,s.sex_name $orderByParam";
    //echo "<pre>$sql</pre>"; //debug

    $r = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($r)) {
      $a = mysql_fetch_rowsarr($r);
      $countStore = array();

      $group_by_array = explode(',', $group_by);

      foreach ($a as $row) {
        $numberOfCol = count($group_by_array);
        $str = "";
        for ($i = 0; $i <= $numberOfCol; $i++) {
          $str.=$row[$i] . "|";
        }
        $countStore[$str] = $row[$i];
      }
      if (count($countStore)) {
        return $countStore;
      }
    }
  }
  return FALSE;
  //myprint_r($countStore);
}

function getFilledPostCount($additionalWheres = " AND p.staff_id_2>0 ") {
  global $tableName;
  global $SQLWhereStatement;
  global $group_by;
  global $orderByParam;

  if (strlen(trim($group_by))) {

    $sql = "SELECT $group_by, count(*) as total FROM $tableName $SQLWhereStatement $additionalWheres GROUP BY $group_by,s.sex_name $orderByParam";
    //echo "<pre>$sql</pre>"; //debug

    $r = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($r)) {
      $a = mysql_fetch_rowsarr($r);
      $countStore = array();

      $group_by_array = explode(',', $group_by);

      foreach ($a as $row) {
        $numberOfCol = count($group_by_array);
        $str = "";
        for ($i = 0; $i <= $numberOfCol; $i++) {
          $str.=$row[$i] . "|";
        }
        $countStore[$str] = $row[$i];
      }
      if (count($countStore)) {
        return $countStore;
      }
    }
  }
  return FALSE;
  //myprint_r($countStore);
}

function getColNameWoutDot($str) {
  $str = trim($str, ". ");
  if (strlen($str)) {
    if (strstr($str, ".")) {
      $a = array();
      $a = explode('.', $str);
      return $a[1];
    }
  }
  return $str;
}

function getGroupByArrayWoutPrefix($groupbyWithTblPrefix) {
  if (strlen($groupbyWithTblPrefix)) {
    $a = explode(',', $groupbyWithTblPrefix);
    $temp = array();
    for ($i = 0; $i < count($a); $i++) {
      $temp[$i] = getColNameWoutDot($a[$i]);
    }
    return $temp;
  }
}

?>