<script type="text/javascript">
    // load division
    $('#admin_division').change(function() {
        $("#loading_content").show();
        var div_code = $('#admin_division').val();
        $.ajax({
            type: "POST",
            url: 'get/get_districts.php',
            data: {div_code: div_code},
            dataType: 'json',
            success: function(data)
                {
                $("#loading_content").hide();
                var admin_district = document.getElementById('admin_district');
                admin_district.options.length = 0;
                    for (var i = 0; i < data.length; i++) {
                    var d = data[i];
        admin_district.options.add(new Option(d.text, d.value));
    }
            }
    });
    });
    // load district
        $('#admin_district').change(function() {
        var dis_code = $('#admin_district').val();
            $("#loading_content").show();
            $.ajax({
            type: "POST",
            url: 'get/get_upazilas.php',
            data: {dis_code: dis_code, key: 'id'},
            dataType: 'json',
                success: function(data)
                {
                $("#loading_content").hide();
                var admin_upazila = document.getElementById('admin_upazila');
                    admin_upazila.options.length = 0;
                    for (var i = 0; i < data.length; i++) {
                    var d = data[i];
    admin_upazila.options.add(new Option(d.text, d.value));
                }
            }
        });
    });
</script>
<script type="text/javascript">
    var tableToExcel = (function() {
                    var uri = 'data:application/vnd.ms-excel;base64,'
                    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                }
        , format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) {
                return c[p];
            })
        }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>

<script type="text/javascript">
            $('table#datatable').dataTable({
        //"bJQueryUI": true,
            "bPaginate": false,
        "sPaginationType": "full_numbers",
                    "aaSorting": [[0, "desc"]],
        "iDisplayLength": 25,
                    "bStateSave": true,
        "bInfo": true,
                    "bProcessing": true,
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
                    "sSwfPath": "assets/datatable/TableTools/media/swf/copy_csv_xls_pdf.swf"
        }
    });
</script>
<script type="text/javascript">
//    $('.multiselect').multiselect({
//        includeSelectAllOption: true,
//        maxHeight: 200,
//    });
</script>
<script type="text/javascript">
    $(document).ready(function() { $(".multiselect").select2(  ); });
</script>