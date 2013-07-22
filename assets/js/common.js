$(function() {
    $('#source_of_electricity_main_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_source_of_electricity_main.php'
    });
});
$(function() {
    $('#source_of_electricity_alternate_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_source_of_electricity_alter.php'
    });
});
$(function() {
    $('#source_of_water_supply_main_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_source_of_water_supply_main_code.php'
    });
});
$(function() {
    $('#source_of_water_supply_alternate_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_source_of_water_supply_alternate_code.php'
    });
});
$(function() {
    $('#toilet_type_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_toilet_type_code.php'
    });
});
$(function() {
    $('#toilet_adequacy_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_toilet_adequacy_code.php'
    });
});
$(function() {
    $('#toilet_adequacy_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_toilet_adequacy_code.php'
    });
});
$(function() {
    $('#fuel_source_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_fuel_source_code.php'
    });
});
$(function() {
    $('#laundry_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_laundry_code.php'
    });
});
$(function() {
    $('#autoclave_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_autoclave_code.php'
    });
});
$(function() {
    $('#waste_disposal_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_waste_disposal_code.php'
    });
});
$(function() {
    $('#organization-profile-details a.text-input').editable({
        type: 'text',
        pk: org_code,
        url: 'post/post_org_profile.php',
    });
});
$(function() {
    $('#org_type_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_type_name.php'
    });
});
$(function() {
    $('#agency_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_agency_code.php'
    });
});
$(function() {
    $('#org_function_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_function_code.php'
    });
});

$(function() {
    $('#org_level_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_level_code.php'
    });
});

$(function() {
    $('#division_name').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_division_name.php'
    });
});

$(function() {
    $('#division_name').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_division_name.php'
    });
});


$(function() {
    $('#ownership_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_ownership.php'
    });
});

$(function() {
    $('#org_healthcare_level_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_health_care.php'
    });
});

$(function() {
    $('#special_service_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_special_service_code.php'
    });
});

//post_type_id
$(function() {
    $('#post_type_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_post_type_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//get_department_id
$(function() {
    $('#department_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_department_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//religion
$(function() {
    $('#religion').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_religous_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//marital_status
$(function() {
    $('#marital_status').editable({
         type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_marital_status_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//sex
$(function() {
    $('#sex').editable({
         type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_sex_type_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//freedom_fighter_idtribal_id
$(function() {
    $('#freedom_fighter_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_freedom_fighter_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//tribal_id
$(function() {
    $('#tribal_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_tribal_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//staff_job_class
$(function() {
    $('#staff_job_class').editable({
         type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_job_class_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});


// staff_professional_category
$(function() {
    $('#staff_professional_category').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_staff_professional_category_id.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//  staff_posting
$(function() {
    $('#staff_posting').editable({
        type: 'select',
        pk: staff_id,
        source: "get/get_staff_posting_type.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//  work_status
$(function() {
    $('#working_status_id').editable({
        type: 'select',
        pk: staff_id,
        source: "get/get_working_status_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});


// staff job posting

$(function() {
    $('#job_posting_id').editable({
        type: 'select',
        pk: staff_id,
        source: "get/get_job_posting_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});
// salary draw type

$(function() {
    $('#draw_type_id').editable({
        type: 'select',
        pk: staff_id,
        source: "get/get_draw_type_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});


