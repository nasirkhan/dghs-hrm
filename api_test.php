<!DOCTYPE html>
<html>
    <head>
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
        </script>
        <script>
            $(document).ready(function() {
                $("button").click(function() {
                    $.ajax({
                        type: "POST",
                        url: 'http://test.dghs.gov.bd/hrmnew/api.php',
                        dataType: 'json',
                        data: {
                            staff_id: '49633', 
                            format: 'json'
                        },
                        success: function(data)
                        {
                            var data_load = document.getElementById('data_load');
                            $.each(data, function(key, value){
                                $.each(value, function(key, value){                                    
                                    $(data_load).append("<br />" + key + " : " + value);
                                    
                                });
                            });
                        }
                    });
                });
            });
        </script>-->
    </head>
    <body>
        <pre>
        <br /><br /> Jquery Example<hr><br /><br />
        <button>Get JSON data</button>
                        <div id="data_load"></div>
        <br /><br /><hr><br /><br />
        
        <?php
        echo "PHP example<br />";
        $data = file_get_contents("http://test.dghs.gov.bd/hrmnew/api.php?staff_id=49633&format=json");

        $data= json_decode($data, true);

        print_r($data); 
        
        echo $data[0]['staff_name'];
        echo "</pre>";   
        ?>
    </body>
</html>


