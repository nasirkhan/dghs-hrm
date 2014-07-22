<input name="f_advancedOptions" value="1" checked="checked" type="checkbox"/> <b>Advanced Options</b> <br/>
              <table id="advancedOptions">
                <tr>
                  <td>
                    <?php
                    $checked = "";
                    if ($_REQUEST['show_sql'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="show_sql" value="true" <?= $checked ?>/> Show SQL query
                  </td>
                  <td>
                    <?php
                    $checked = "";
                    if ($_REQUEST['highlight_empty_cell'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="highlight_empty_cell" value="true" <?= $checked ?>/>Highlight empty cell
                  </td>
                  <td>
                    <?php
                    $checked = "";
                    if ($_REQUEST['tableheader_without_underscore'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="tableheader_without_underscore" value="true" <?= $checked ?>/>Remove '_' from table header
                    <?php
                    $checked = "";
                    if ($_REQUEST['HideFilter'] == 'true') {
                      $checked = " checked='checked' ";
                    }
                    ?>
                    <input type="checkbox" name="HideFilter" value="true" <?= $checked ?>/>Hide filters
                  </td>
                </tr>
              </table>