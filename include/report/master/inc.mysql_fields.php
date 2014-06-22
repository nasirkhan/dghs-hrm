<table>
  <tr>
    <td style="vertical-align:top;">
      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_columns'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_columns" value="1" checked="checked" type="checkbox"/>
        <b>View Columns</b><br/>
        <?php
        createMultiSelectOptions("INFORMATION_SCHEMA.COLUMNS", "COLUMN_NAME", "COLUMN_NAME", $allColSelection, $showFieldsCsv, "f[]", " class='multiselect' ");
        echo "<br/>";
      }
      ?>
      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_field_query'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_field_query" value="1" checked="checked" type="checkbox"/>
        <b><i class="icon-list-ul"></i> Field query</b><br/>
        <table>
          <tr>
            <td><b>Field</b></td>
            <td><?php createSelectOptions('INFORMATION_SCHEMA.COLUMNS', 'COLUMN_NAME', 'COLUMN_NAME', $allColSelection, "search_field", " id = 'search_field' class = 'pull-left' ", $optionIdField) ?></td>
          </tr>
          <tr>
            <td><b>Criteria</b></td>
            <td><?php
              $listArray = array('=', 'LIKE', '>', ">=", "<", "<=");
              createSelectOptionsFrmArray($listArray, $_REQUEST['search_criteria'], 'search_criteria', $params = "");
              ?>
            </td>
          </tr>
          <tr>
            <td><b>Value</b></td>
            <td><input class='' name="search_value" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;" value="<?php echo addEditInputField('search_value'); ?>" /></td>
          </tr>
        </table>
      <?php } ?>

    </td>
    <td>
      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_SQLSelect'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_SQLSelect" value="1" checked="checked" type="checkbox"/>
        <b>Additional SQL select criteria</b><br/>
        <?php
        $Intype = 'text';
      } else {
        $Intype = 'hidden';
      }
      ?>
      <input type="<?= $Intype ?>" name="SQLSelect" value="<?php echo addEditInputField('SQLSelect'); ?>" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;"/>
      <br/>

      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_SQLGroup'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_SQLGroup" value="1" checked="checked" type="checkbox"/>
        <b>Group by</b> (csv)<br/>
        <?php
        $Intype = 'text';
      } else {
        $Intype = 'hidden';
      }
      ?>
      <input  type="<?= $Intype ?>" name="SQLGroup" value="<?php echo addEditInputField('SQLGroup'); ?>" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;"/>
      <br/>

      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_ColOrder'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_ColOrder" value="1" checked="checked" type="checkbox"/>
        <b>Column Sequence</b> (csv)
        <br/>
        <?php
        $Intype = 'text';
      } else {
        $Intype = 'hidden';
      }
      ?>
      <input type="<?= $Intype ?>" name="ColOrder" value="<?php echo addEditInputField('ColOrder'); ?>" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;"/><br/>


      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_ColAlias'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_ColAlias" value="1" checked="checked" type="checkbox"/>
        <b>Column Alias</b> (csv)
        <br/>
        <?php
        $Intype = 'text';
      } else {
        $Intype = 'hidden';
      }
      ?>
      <input type="<?= $Intype ?>" name="ColAlias" value="<?php echo addEditInputField('ColAlias'); ?>" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;"/>
      <br/>


      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_order_sort'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_order_sort" value="1" checked="checked" type="checkbox"/>
        <b>Order by</b>
        <?php
        createSelectOptions('INFORMATION_SCHEMA.COLUMNS', 'COLUMN_NAME', 'COLUMN_NAME', $allColSelection, $_REQUEST['order_by'], "order_by", " id='order_by'  class='pull-left' ", $optionIdField);

        $listArray = array('ASC', 'DESC');
        createSelectOptionsFrmArray($listArray, $_REQUEST['order_sort'], 'order_sort', $params = "");
        echo "<br/>";
      }
      ?>

      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_orderbyfull'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_orderbyfull" value="1" checked="checked" type="checkbox"/>
        <b>Order by </b> <small>(fieldName ASC, fielName2 DESC ...)</small>
        <br/>
        <?php
        $Intype = 'text';
      } else {
        $Intype = 'hidden';
      }
      ?>
      <input type="<?= $Intype ?>" name="orderbyfull" value="<?php echo addEditInputField('orderbyfull'); ?>" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;"/>
      <br/>


      <?php if ((isset($_REQUEST['submit']) && $_REQUEST['f_rTitle'] == '1') || !isset($_REQUEST['submit'])) { ?>
        <input name="f_rTitle" value="1" checked="checked" type="checkbox"/>
        <b>Report title</b>
        <br/>
        <?php
        $Intype = 'text';
      } else {
        $Intype = 'hidden';
      }
      ?>
      <input type="<?= $Intype ?>" name="rTitle" value="<?php echo addEditInputField('rTitle'); ?>" style="border: 1px solid #CCCCCC; height: 15px; width: 142px;"/>
      <br/>
    </td>
  </tr>
</table>