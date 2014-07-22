<?php
require_once 'configuration.php';
if ($_SESSION['logged'] != true) {
  header("location:login.php");
}
require_once './include/report/master/inc.functions.php';
$t = $_REQUEST['t']; // $t = report type 'staff','post'
/**
 * Config
 */
$rTitle = $_REQUEST['t']; // report title
require_once './include/report/master/inc.master.config.php';
require_once './include/report/master/inc.select.defn.php';


// checks for value inconsistency
$DBvalidation = FALSE;
if ($_REQUEST['highlight_empty_cell'] == 'true') { // checks for empty cells
  $DBvalidation = TRUE;
}

// just to easily create readable names from db field names. this is a lame feature anyway :) but it helps reduce the column width
$replaceUnderScoreWithSpace = FALSE;
if ($_REQUEST['tableheader_without_underscore'] == 'true') {
  $replaceUnderScoreWithSpace = TRUE;
}

// forms submission
if (isset($_REQUEST['submit']) && strlen($_REQUEST['submit'])) {
  if (strlen(trim($_REQUEST['rTitle']))) {
    $rTitle = trim($_REQUEST['rTitle']);
  }
  $parameterized_query = " WHERE 1 "; // default parameter query

  foreach ($singleSelectItems as $singleSelectItem) {
    if (strlen($_REQUEST[$singleSelectItem]) && $_REQUEST[$singleSelectItem] > 0) {
      $parameterized_query.=" AND $tableFieldMap[$singleSelectItem] = '" . mysql_real_escape_string(trim($_REQUEST[$singleSelectItem])) . "' ";
    }
  }

  $csvs = array();
  foreach ($multiSelectItems as $multiSelectItem) {
    if (count($_REQUEST[$multiSelectItem])) {
      $csvs[$multiSelectItem] = "'" . implode("','", $_REQUEST[$multiSelectItem]) . "'";
      $parameterized_query.=" AND $tableFieldMap[$multiSelectItem] in (" . $csvs[$multiSelectItem] . ")  ";
      //$selection_string .= " Agency: <strong>" . getAgencyNameFromAgencyCode($agency_code) . "</strong>";
    }
  }

  if (strlen($_REQUEST['search_field']) && strlen($_REQUEST['search_criteria']) && strlen($_REQUEST['search_value'])) {
    if (in_array($_REQUEST['search_criteria'], array('=', '<', '<=', '>', '>='))) {
      $parameterized_query.=" AND " . $_REQUEST['search_field'] . " " . $_REQUEST['search_criteria'] . " " . $_REQUEST['search_value'] . "  ";
    } else if ($_REQUEST['search_criteria'] == "LIKE") {
      $parameterized_query.=" AND " . $_REQUEST['search_field'] . " " . $_REQUEST['search_criteria'] . " '%" . $_REQUEST['search_value'] . "%'  ";
    }
  }

  if (strlen(trim($_REQUEST['SQLSelect']))) {
    $parameterized_query.= " AND " . trim(($_REQUEST['SQLSelect']));
  }

  $SQLWhereStatement = $parameterized_query;

  /*
   *    SQL GROUP BY
   */
  $countField = "";
  if (strlen(trim($_REQUEST['SQLGroup']))) {
    $group_by = trim($_REQUEST['SQLGroup']);
    $parameterized_query .= " GROUP BY $group_by ";
    $countField = ",COUNT(*) as total";
  }

  /**
   * Show fields
   */
  $TableFields = getTableFieldNamesFrmMultipleTables(array($staffsBaseTable['tableName'], $organizationsBaseTable['tableName'], $sanctionedpostsBaseTable['tableName']));

  //myprint_r($TableFields);

  if (count($_REQUEST['f'])) {
    $showFields = $_REQUEST['f'];
  }
  $showFieldsCsv = implode(',', $showFields);

  /*   * **************** */

  /*   * **
   * If order is set then it over rides the f[]
   */
  if (strlen(trim($_REQUEST['ColOrder']))) {

    $showFieldsCsv = str_replace(" ", '', trim($_REQUEST['ColOrder'], " ,"));
    $showFields = explode(',', $showFieldsCsv);
  }
  if (strlen(trim($_REQUEST['ColAlias']))) {

    $colAliasCsv = trim($_REQUEST['ColAlias']);
    $colAlias = explode(',', $colAliasCsv);
    if (count($showFields) != count($colAlias)) {
      echo "Column Alias must have same number of column";
      exit();
    }
  }



  if (strlen(trim($_REQUEST['order_by'])) && strlen(trim($_REQUEST['order_sort']))) {
    $order_by = trim($_REQUEST['order_by']);
    $order_sort = trim($_REQUEST['order_sort']);

    $orderByParam = " ORDER BY $order_by $order_sort ";
  }

  if (strlen(trim($_REQUEST['orderbyfull']))) {
    $orderByParam = " ORDER BY " . trim($_REQUEST['orderbyfull']);
  }


  $parameterized_query .= $orderByParam;
  /*   * *********** */

  $sql = "SELECT * $countField FROM $tableName $parameterized_query";

  $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
  $count = mysql_num_rows($result);


  $fieldNameAlias = array();

  $sexCountArray = getSexGroupedCount();
  $filledPostCountArray = getFilledPostCount();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Report</title>
    <?php
    include_once 'include/header/header_css_js.inc.php';
    include_once 'include/header/header_ga.inc.php';
    ?>
    <link href="assets/css/report.css" rel="stylesheet"/>
  </head>
  <body>
    <?php include_once 'include/header/header_top_menu.inc.php'; ?>
    <br/>
    <div class="container">
      <h4 style="text-transform: uppercase">Report : <?php echo $rTitle; ?></h4>
      <?php if ($_REQUEST['HideFilter'] != 'true') { ?>

        <div id="showHide" style="cursor: pointer">
          <span id="showHideBtn" >[ - ] Hide Filters</span>
        </div>
        <div class = "filter" id = "filter">
          <form class = "form-horizontal" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "get" style = "padding: 0px; margin: 0px;"> <input type="hidden" name="t" value="<?= $_REQUEST['t']; ?>"/>
            <table id="filter">
              <tr>
                <td>
                  <?php
                  require_once './include/report/master/inc.filter.admin.php';
                  $checked = "";
                  if ($_REQUEST['noDatatable'] == 'true') {
                    $checked = " checked='checked' ";
                  }
                  ?>
                  <input type="checkbox" name="noDatatable" value="true" <?= $checked ?>/> Optimize loading
                </td>
                <td><?php require_once './include/report/master/inc.filter.orgdetails1.php'; ?></td>
                <td><?php require_once './include/report/master/inc.filter.orgdetails2.php'; ?></td>
                <td><?php require_once './include/report/master/inc.filter.staffdetails1.php'; ?></td>
                <td><?php require_once './include/report/master/inc.filter.staffdetails2.php'; ?></td>
                <td><?php require_once './include/report/master/inc.filter.postdetails1.php'; ?></td>
                <td><?php include_once './include/report/master/inc.mysql_fields.php'; ?></td>
              </tr>
            </table>
            <table>
              <tr>
                <td>
                  <div class="btn-group">
                    <button name="submit" type="submit" class="btn btn-success" style="text-transform: uppercase" value="generate_report">Generate Report</button>
                    <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="btn" style="text-transform: uppercase">Reset</a>
                    <a id="loading_content" href="#" class="btn btn-info disabled" style="display:none;text-transform: uppercase"><i class="icon-spinner icon-spin icon-large"></i> Loading content...</a>
                  </div>
                </td>
            </table>
            <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_advancedOptions'] == '1') || !isset($_REQUEST['submit'])) { ?>
              <?php include_once './include/report/master/inc.filter.advanced.php'; ?>
            <?php } ?>
          </form>
        </div>
        <?php
        if (strlen($sql) && $_REQUEST['show_sql'] == 'true') {
          echo "<pre class='pull-left'>$sql</pre>";
        }
      }
      if (isset($_REQUEST['submit']) && strlen($_REQUEST['submit'])) {
        ?>
        <blockquote class="pull-left clearfix"><?php echo "$selection_string"; ?></blockquote>
        <blockquote class="pull-left clearfix">
          Total <strong><em><?= $count ?></em></strong> result(s) found.<br />
        </blockquote>
        <?php if ($_REQUEST['noDatatable'] == 'true') { ?>
          <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export CSV" class="btn pull-right" />
        <?php } ?>

        <?php
        if ($_REQUEST['noDatatable'] == 'true') {
          $param = "";
        } else {
          $param = " id='datatable' ";
        }
        ?>

        <table class="table table-condensed table-bordered" <?= $param ?> id="testTable">

          <thead>
            <tr>
              <?php
              //myprint_r($showFields);
              $i = 0;
              foreach ($showFields as $fieldName) {
                if (in_array($fieldName, $TableFields)) {
                  ?>
                  <th id="<?= $fieldName ?>"><strong><a href="#" title="<?= $fieldName ?>">
                        <?php
                        if (strlen($fieldNameAlias[$fieldName])) {
                          if ($replaceUnderScoreWithSpace) {
                            $fieldName = str_replace('_', ' ', $fieldNameAlias[$fieldName]);
                          } else {
                            $fieldName = $fieldNameAlias[$fieldName];
                          }
                        } else {
                          if ($replaceUnderScoreWithSpace) {
                            $fieldName = str_replace('_', ' ', $fieldName);
                          }
                        }
                        if (strlen($colAlias[$i])) {
                          $fieldName = $colAlias[$i];
                          $i++;
                        }
                        echo $fieldName;
                        ?>
                      </a>
                    </strong>
                  </th>
                  <?php
                }
              }
              if (strlen($countField)) {
                echo "<th><b>Total $t</b></th>";
              }
              if ($sexCountArray) {
                echo "<th><b>Male</b></th><th><b>Female</b></th><th><b>Filled up</b></th><th><b>Vacant</b></th>";
              }
              ?>

            </tr>
          </thead>
          <tbody>
            <?php
            $subTotal = 0;
            //echo "<pre>group_by $group_by </pre>"; //debug
            $group_by_array = getGroupByArrayWoutPrefix($group_by);
            //myprint_r($group_by_array); // debug
            $maleCountTotal = $femaleCountTotal = $filledupTotal = $vacantTotal = 0;

            while ($data = mysql_fetch_assoc($result)) {
              ?>
              <tr>
                <?php
                $totalFields = count($showFields);
                $filledFields = 0;
                foreach ($showFields as $fieldName) {
                  if (in_array($fieldName, $TableFields)) {
                    if ($DBvalidation == TRUE) {
                      $tdClass = "";
                      if (!strlen($data[$fieldName])) {
                        $filledFields++;
                        $tdClass = "bgRed";
                      } else {

                        //  }
                      }
                    }
                    ?>
                    <td class="<?= $tdClass ?>">
                      <?php
                      if ($fieldName == 'staff_name') {
                        echo "<a target='_blank' href='employee.php?staff_id=" . $data[staff_id] . "'>" . $data[$fieldName] . "</a>";
                      } else if ($fieldName == 'org_name') {
                        echo "<a target='_blank' href='org_profile.php?org_code=" . $data[org_code] . "'>" . $data[$fieldName] . "</a>";
                      } else {
                        echo $data[$fieldName];
                      }
                      ?>
                    </td>
                    <?php
                  }
                }
                if (strlen($countField)) {
                  $subTotal+=$data['total'];
                  echo "<td>" . $data['total'] . "</td>";
                }
                if ($sexCountArray) {
                  $stringTok = "";
                  foreach ($group_by_array as $ga) {
                    $stringTok .= $data[$ga] . "|";
                  }
                  //echo $sexCountArray[]."|".] $maleCountTotal = $femaleCountTotal = $filledupTotal = $vacantTotal = 0;
                  $maleCount = 0;
                  if (strlen($sexCountArray[$stringTok . "Male|"])) {
                    $maleCount = $sexCountArray[$stringTok . "Male|"];
                    $maleCountTotal+=$maleCount;
                  }
                  $femaleCount = 0;
                  if (strlen($sexCountArray[$stringTok . "Female|"])) {
                    $femaleCount = $sexCountArray[$stringTok . "Female|"];
                    $femaleCountTotal+=$femaleCount;
                  }
                  $filledupCount = $maleCount + $femaleCount;
                  $filledupTotal+=$filledupCount;
                  $vacantCount = $data['total'] - $filledupCount;
                  $vacantTotal+=$vacantCount;

                  echo "<td>$maleCount</td>";
                  echo "<td>$femaleCount</td>";
                  echo "<td>$filledupCount</td>";
                  echo "<td>$vacantCount</td>";
                }
                ?>

              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php }
      ?>
      <table class='table table-condensed table-bordered pull-right span3'>
        <?php
        if (strlen($countField)) {
          echo "<tr><td>Total</td> <td>" . $subTotal . "</td></tr>";

          if ($sexCountArray) {
            echo "<tr><td>Total male</td> <td>" . $maleCountTotal . "</td></tr>";
            echo "<tr><td>Total female</td> <td>" . $femaleCountTotal . "</td></tr>";
            echo "<tr><td>Total filled</td> <td>" . $filledupTotal . "</td></tr>";
            echo "<tr><td>Total vacant</td> <td>" . $vacantTotal . "</td></tr>";
          }
        }
        ?>
      </table>
      <?php if (strlen($showFieldsCsv)) { ?>
        <div class="clearfix"></div>
        <h5>TABLE FIELD NAMES</h5>
        <pre>
          <?php echo trim($showFieldsCsv, ", "); ?>
        </pre>
      <?php } ?>
    </div>

    <!-- Footer
    ================================================== -->
    <?php
    include_once './include/footer/footer.inc.php';
    include_once './include/report/report_org_list/report_org_list.js.php';
    require_once './include/report/master/inc.js.php';
    ?>

  </body>
</html>
