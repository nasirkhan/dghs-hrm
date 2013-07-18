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