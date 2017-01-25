/* ------------------------------------------------------------------------------
*
*  # Form validation for idsc center
*
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Form components
    // ------------------------------
    $("#user_photo").change(function () {
        previewImage(this, 'preview_user_image');
    });

    // Default initialization
    $('.select').select2({
    });


    // Styled checkboxes, radios
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice' });

    // Styled file input
    $(".file-styled").uniform({
        wrapperClass: 'bg-teal-400',
        fileButtonHtml: '<i class="icon-googleplus5"></i>'
    });


    // Setup validation
    // ------------------------------
    // date format validation
    jQuery.validator.addMethod("dateBD", function(value, element) {
        // valid date format DD-MM-YYYY
        return this.optional( element ) ||  /^(0?[1-9]|[12][0-9]|3[01])[\-](0?[1-9]|1[012])[\-]\d{4}$/.test( value );
    }, 'Please enter a valid date.');

    // Initialize
    var validator = $("#frm_user").validate({
        ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Styled checkboxes, radios, bootstrap switch
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }

            // Input with icons and Select2
            else if (element.parents('div').hasClass('has-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo(element.parent());
            }

            // Inline checkboxes, radios
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }

            // Input group, styled file input
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }

            else {
                error.insertAfter(element);
            }
        },
        validClass: "validation-valid-label",

        rules: {
            full_name: {
                required: true,
                minlength: 5
            },
            designation_id: {
                required: true,
                integer: true
            },
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                minlength: 3
            },
            official_email: {
                email: true
            },
            national_id: {
                minlength: 13
            }
        },
        messages: {
            email: {
                required: "Provide valid and unique User Name / Login ID",
            },
            official_email: {
                email: "Provide center valid email addess"
            }
        }
    });


    // Reset form
    $('#reset').on('click', function() {
        validator.resetForm();
    });

});
