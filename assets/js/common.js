var staff_id;

/**
 * 
 * Organization Profile Page
 * org_profile.php
 */

//
//Basic Informatoin 
//

//agency_code
$(function() {
    $('#agency_code').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_agency_code.php'
    });
});

//org_location_type
$(function() {
    $('#org_location_type').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_location_type.php'
    });
});

//division_name
$(function() {
    $('#division_name').editable({
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_division_name.php'
    });
});

//upazila_thana_name
$(function() {
    $('#upazila_thana_name').editable({        
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_upazila_thana_name.php',
        params: function(params) {
            params.div_name = selected_div_name;
            return params;
        }
    });
});

//district_name
$(function() {
    $('#district_name').editable({        
        type: 'select',
        pk: org_code,
        url: 'post/post_org_profile.php',
        source: 'get/get_org_district_name.php',
        params: function(params) {
            params.div_name = selected_div_name;
            return params;
        }
    });
});

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
        url: 'post/post_org_profile.php'
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
        source: [
            {value: 1, text: 'Muslim'},
            {value: 2, text: 'Hindu'},
            {value: 3, text: 'Christian'},
            {value: 4, text: 'Buddha'},
            {value: 5, text: 'Other'}
        ],
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
        source: [
            {value: 1, text: 'Married'},
            {value: 2, text: 'Unmarried'},
            {value: 3, text: 'Single'},
            {value: 4, text: 'Widow/Widower'},
            {value: 5, text: 'Devorced'},
            {value: 6, text: 'Separated'},
            {value: 7, text: 'Other'}
        ],
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
        source: [
            {value: 1, text: 'Yes'},
            {value: 2, text: 'No'}
        ],
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
        source: [
            {value: 1, text: 'Tribal'},
            {value: 2, text: 'Not Tribal'}
        ],
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
        source: [
            {value: 1, text: 'Class I'},
            {value: 2, text: 'Class II'},
            {value: 3, text: 'Class III'},
            {value: 4, text: 'Class IV'}
        ],
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
        source: [
            {value: 1, text: 'Medical Technologist'},
            {value: 2, text: 'Physican'},
            {value: 3, text: 'Other'},
            {value: 4, text: 'Nurse'},
            {value: 1, text: 'Field Staff'},
            {value: 2, text: 'Nurse'},
            {value: 3, text: 'Other'},
            {value: 4, text: 'Other'},
            {value: 4, text: 'Other'}
        ],
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