<!-- JQuery Modal Popup for delete : Start --->
<div id="dialog" title="Confirm" style="display: none;">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input name="param" type="hidden" value="delete" />
        <input name="<?= $dbTablePrimaryKeyFieldName ?>" type="hidden" value="" />
        <input name="confirm_checkbox" type="checkbox" value="confirmed" class="validate[required]" />
        <?php echo $defaultConfirmationMsg; ?>
        <div class="clear"></div>
        <input type="submit" name="confirm" value="confirm" class="bgblue button" />
    </form>
</div>
<!-- JQuery Modal Popup for delete : Ends --->
<script>
    $('document').ready(function() {
        $("#dialog").dialog({autoOpen: false, });
        $('a.cf_delete').click(function() {
            var date_exclusion_id = $(this).attr('id');
            //alert(date_exclusion_id);
            $('input[name=date_exclusion_id]').val(date_exclusion_id);
            $("#dialog").dialog('open');
        });
    });
</script>
