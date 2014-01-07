<?php

foreach ($requiredFieldNames as $requiredFieldName) {
    if (empty($_POST["$requiredFieldName"])) {
        $valid = false;
        array_push($alert, "Please fillup the field: $requiredFieldName");
    }
}
?>