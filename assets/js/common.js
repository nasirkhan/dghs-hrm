var staff_id;
var special_service_code_values;
var fuel_source_code_values;
var laundry_code_values;
var autoclave_code_values;
var waste_disposal_code_values;
var type_of_educational_qualification;
var pay_scale_of_current_designation;
var org_function_value;
var org_code;

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
        url: 'post/post_employee.php',
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
        url: 'post/post_employee.php',
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
        url: 'post/post_employee.php',
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
        url: 'post/post_employee.php',
        source: "get/get_draw_type_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

// salary draw head
$(function() {
    $('#draw_salary_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: "get/get_draw_salary_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

// education qualification

//$(function() {
//    $('#type_of_educational_qualification').editable({
//        type: 'select',
//        pk: staff_id,
//        source: "get/get_type_of_educational_qualification.php",
//        params: function(params) {
//            params.org_code = org_code;
//            return params;
//        }
//    });
//});

// Govt Quater

$(function() {
    $('#govt_quarter_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: "get/get_govt_quater_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

// Designation Type

$(function() {
    $('#designation_type_id').editable({
        type: 'select',
        pk: staff_id,
        url: 'post/post_employee.php',
        source: "get/get_designation_type_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

// Professional discipline

$(function() {
    $('#professional_discipline_of_current_designation').editable({
        type: 'select',
        pk: staff_id,
         url: 'post/post_employee.php',
        source: "get/get_professional_discipline_id.php",
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//type_of_educational_qualification
$(function() {
    $('#type_of_educational_qualification').editable({
        type: 'checklist',
        value: type_of_educational_qualification,
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_type_of_educational_qualification.php',
        params: function(params) {
            params.org_code = org_code;
            params.post_type = 'checklist';
            return params;
        }
    });
});

//pay scale
$(function() {
    $('#pay_scale_of_current_designation').editable({
        type: 'select',
        value: pay_scale_of_current_designation,
        pk: staff_id,
        url: 'post/post_employee.php',
        source: 'get/get_pay_scale_of_designation.php',
        params: function(params) {
            params.org_code = org_code;
            return params;
        }
    });
});

//birth_date
//$(function() {
//    $('#birth_date').editable({
//        type: 'combodate',
//        pk: staff_id,
//        source: "get/get_draw_type_id.php",
//        format: 'YYYY-MM-DD',
//        viewformat: 'DD.MM.YYYY',
//        template: 'D / MMMM / YYYY',
//        params: function(params) {
//            params.org_code = org_code;
//            return params;
//        },
//        combodate: {
//            minYear: 1930,
//            maxYear: 2015,
//            minuteStep: 1
//        }
//    });
//});
//

/*
 * DataTable
 -------------------------------------------------*/
/* Set the defaults for DataTables initialisation */
$.extend(true, $.fn.dataTable.defaults, {
    "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
    "sPaginationType": "bootstrap",
    "oLanguage": {
        "sLengthMenu": "_MENU_ records per page"
    }
});


/* Default class modification */
$.extend($.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
});


/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
{
    return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": oSettings._iDisplayLength === -1 ?
                0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": oSettings._iDisplayLength === -1 ?
                0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
    };
};


/* Bootstrap style pagination control */
$.extend($.fn.dataTableExt.oPagination, {
    "bootstrap": {
        "fnInit": function(oSettings, nPaging, fnDraw) {
            var oLang = oSettings.oLanguage.oPaginate;
            var fnClickHandler = function(e) {
                e.preventDefault();
                if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                    fnDraw(oSettings);
                }
            };

            $(nPaging).addClass('pagination').append(
                    '<ul>' +
                    '<li class="prev disabled"><a href="#">&larr; ' + oLang.sPrevious + '</a></li>' +
                    '<li class="next disabled"><a href="#">' + oLang.sNext + ' &rarr; </a></li>' +
                    '</ul>'
                    );
            var els = $('a', nPaging);
            $(els[0]).bind('click.DT', {action: "previous"}, fnClickHandler);
            $(els[1]).bind('click.DT', {action: "next"}, fnClickHandler);
        },
        "fnUpdate": function(oSettings, fnDraw) {
            var iListLength = 5;
            var oPaging = oSettings.oInstance.fnPagingInfo();
            var an = oSettings.aanFeatures.p;
            var i, ien, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

            if (oPaging.iTotalPages < iListLength) {
                iStart = 1;
                iEnd = oPaging.iTotalPages;
            }
            else if (oPaging.iPage <= iHalf) {
                iStart = 1;
                iEnd = iListLength;
            } else if (oPaging.iPage >= (oPaging.iTotalPages - iHalf)) {
                iStart = oPaging.iTotalPages - iListLength + 1;
                iEnd = oPaging.iTotalPages;
            } else {
                iStart = oPaging.iPage - iHalf + 1;
                iEnd = iStart + iListLength - 1;
            }

            for (i = 0, ien = an.length; i < ien; i++) {
                // Remove the middle elements
                $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                // Add the new list items and their event handlers
                for (j = iStart; j <= iEnd; j++) {
                    sClass = (j == oPaging.iPage + 1) ? 'class="active"' : '';
                    $('<li ' + sClass + '><a href="#">' + j + '</a></li>')
                            .insertBefore($('li:last', an[i])[0])
                            .bind('click', function(e) {
                        e.preventDefault();
                        oSettings._iDisplayStart = (parseInt($('a', this).text(), 10) - 1) * oPaging.iLength;
                        fnDraw(oSettings);
                    });
                }

                // Add / remove disabled classes from the static elements
                if (oPaging.iPage === 0) {
                    $('li:first', an[i]).addClass('disabled');
                } else {
                    $('li:first', an[i]).removeClass('disabled');
                }

                if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
                    $('li:last', an[i]).addClass('disabled');
                } else {
                    $('li:last', an[i]).removeClass('disabled');
                }
            }
        }
    }
});


/*
 * TableTools Bootstrap compatibility
 * Required TableTools 2.1+
 */
if ($.fn.DataTable.TableTools) {
    // Set the classes that TableTools uses to something suitable for Bootstrap
    $.extend(true, $.fn.DataTable.TableTools.classes, {
        "container": "DTTT btn-group",
        "buttons": {
            "normal": "btn",
            "disabled": "disabled"
        },
        "collection": {
            "container": "DTTT_dropdown dropdown-menu",
            "buttons": {
                "normal": "",
                "disabled": "disabled"
            }
        },
        "print": {
            "info": "DTTT_print_info modal"
        },
        "select": {
            "row": "active"
        }
    });

    // Have the collection use a bootstrap compatible dropdown
    $.extend(true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
        "collection": {
            "container": "ul",
            "button": "li",
            "liner": "a"
        }
    });
}


