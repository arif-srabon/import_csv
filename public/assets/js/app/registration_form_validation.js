/* ------------------------------------------------------------------------------
 *
 *  # Form validation for Registration
 *
 *
 * ---------------------------------------------------------------------------- */

$(function () {

    // Form components
    // ------------------------------

    // Default initialization
    $('.select').select2({});

    $("#logo_image").change(function () {
        previewImage(this, 'preview_image');
    });//end files


    // Styled checkboxes, radios
    $(".styled, .multiselect-container input").uniform({radioClass: 'choice'});

    // Styled file input
    $(".file-styled").uniform({
        wrapperClass: 'bg-teal-400',
        fileButtonHtml: '<i class="icon-googleplus5"></i>'
    });

    //$('.daterange-single').daterangepicker({
    //    autoUpdateInput: false,
    //    singleDatePicker: true,
    //    "autoApply": true,
    //    locale: {
    //        cancelLabel: 'Clear',
    //        format: 'DD-MM-YYYY'
    //    }
    //});
    //
    //$('.daterange-single').on('apply.daterangepicker', function (ev, picker) {
    //    $(this).val(picker.startDate.format('DD-MM-YYYY'));
    //});


    //load comboBox value
    $("#frm_registration").relatedSelects({
        onChangeLoad: '/area',
        loadingMessage: 'Please wait',
        selects: ['division_id', 'district_id', 'upazilla_id', 'ward']
    });

    $(document).ready(function () {

        var profession = $('#profession option:selected').text();
        if (profession == 'Other') {
            $("#professionOther").show();
        }
        else {
            $("#professionOther").hide();
        }

        var houseLivingType = $('#houseLivingType option:selected').text();
        if (houseLivingType == 'Other') {
            $("#houseLivingTypeOther").show();
        }
        else {
            $("#houseLivingTypeOther").hide();
        }

        // Showing others field for edit form end

        $('#EduQualification').on('change', function () {
            // var EduQ = $("#EduQualification").val();
            var EduQ = $('#EduQualification option:selected').text();
            if (EduQ == 'Other') {
                $("#EduOthers").show();
            }
            else {
                $("#EduOthers").hide();
            }
        });

        $('#profession').on('change', function () {
            var profession = $('#profession option:selected').text();
            if (profession == 'Other') {
                $("#professionOther").show();
            }
            else {
                $("#professionOther").hide();
            }
        });
        $('#houseLivingType').on('change', function () {
            var houseLivingType = $('#houseLivingType option:selected').text();
            if (houseLivingType == 'Other') {
                $("#houseLivingTypeOther").show();
            }
            else {
                $("#houseLivingTypeOther").hide();
            }
        });
        $('#ReferredBy').on('change', function () {
            var ReferredBy = $('#ReferredBy option:selected').text();
            if (ReferredBy == 'Other') {
                $("#ReferredByOther").show();
            }
            else {
                $("#ReferredByOther").hide();
            }
        });


        $("input:radio[name=is_pwd_dss_registered]").click(function () {
            var value = $(this).val();
            if (value == 'yes') {
                $("#pwdRegId").show();
                $("#pwdRegDate").show();
            }
            else {
                $("#pwdRegId").hide();
                $("#pwdRegDate").hide();
            }
        });
    });

    // Setup validation
    jQuery.validator.addMethod("dateBD", function (value, element) {
        // valid date format DD-MM-YYYY
        return this.optional(element) || /^(0?[1-9]|[12][0-9]|3[01])[\-](0?[1-9]|1[012])[\-]\d{4}$/.test(value);
    }, 'Please Enter a Valid Date.');
    // ------------------------------
    // Initialize
    var validator = $("#frm_registration").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function (element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function (error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container')) {
                if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo(element.parent().parent().parent().parent());
                }
                else {
                    error.appendTo(element.parent().parent().parent().parent().parent());
                }
            }


            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo(element.parent().parent());
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo(element.parent().parent());
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",

        rules: {
            client_id: {
                required: true,
                number: true,
                minlength: 1
            },
            registration_date: {
                required: true,
                dateBD: true
            },
            pwd_dss_reg_issue_date: {
                dateBD: true
            },
            client_name: {
                required: true,
                minlength: 3
            },
            father_name: {
                minlength: 3
            },
            mother_name: {
                minlength: 3
            },
            husband_name: {
                minlength: 3
            },
            guardian_name: {
                minlength: 3
            },
            date_of_birth: {
                required: true,
                dateBD: true
            },
            gender_id: {
                required: true
            },
            national_id: {
                minlength: 13,
                maxlength: 17
            },
            house_no: {
                required: true
            },
            village: {
                minlength: 3
            },
            district_id: {
                required: true
            },
            upazilla_id: {
                required: true
            },
            post_code: {
                required: true
            },
            mobile: {
                required: true,
                minlength: 11
            },
            email: {
                email: true
            },
            education_qualification_id: {
                required: true
            },
            professional_id: {
                required: true
            },
            living_house_id: {
                required: true
            },
            division_id: {
                required: true
            },
            family_member: {
                number: true
            },
            earning_family_member: {
                number: true
            },
            main_problem: {
                minlength: 5
            },
            expectation: {
                minlength: 5
            }
        },
        messages: {
            client_id: {
                required: "Provide Unique Client ID"
            },
            registration_date: {
                required: "Provide Registration Date"
            },
            client_name: {
                required: "Provide Valid Client Name"
            },
            father_name: {
                minlength: "Father Name Must be at least 3 Character"
            },
            mother_name: {
                minlength: "Mother Name Must be at least 3 Character"
            },
            husband_name: {
                minlength: "Husband Name Must be at least 3 Character"
            },
            guardian_name: {
                minlength: "Guardian Name Must be at least 3 Character"
            },
            date_of_birth: {
                required: "Provide Date of Birth"
            },
            national_id: {
                minlength: "National ID Must be at least 13 Character",
                maxlength: "National id Should not More Than 17 Character"
            },
            gender_id: {
                required: "Select Gender"
            },
            house_no: {
                required: "Provide House No."
            },
            village: {
                minlength: "Village Name Must be at least 3 Character"
            },
            district_id: {
                required: "Select District"
            },
            division_id: {
                required: "Select Division"
            },
            upazilla_id: {
                required: "Select Upazila"
            },
            post_code: {
                required: "Select Post Code"
            },
            mobile: {
                required: "Provide Valid Mobile No."
            },
            education_qualification_id: {
                required: "Select Educational Qualification"
            },
            professional_id: {
                required: "Select Profession"
            },
            living_house_id: {
                required: "Select Type of House"
            },
            family_member: {
                number: "Provide Valid Number"
            },
            earning_family_member: {
                number: "Provide Valid Number"
            },
            status: "Please Select a Status"
        }
    });


    // Reset form
    $('#reset').on('click', function () {
        validator.resetForm();
    });

});
