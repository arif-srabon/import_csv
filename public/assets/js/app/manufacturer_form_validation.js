/**
 * Form Validation : Manufacturer
 *
 * @package  ADR_DGA
 * @author   Mayeenul Islam
 * @since    1.0.0
 */

$(function() {


    // Setup validation
    // ------------------------------

    // Initialize
    var validator = $("#manufacturer-form").validate({
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
            division_id: {
                required: true,
            },
            district_id: {
                required: true,
            },
			code: {
                required: true
            },
            code_non_bio: {
                required: true
            },
            name: {
                required: true,
                minlength: 3
            },
            name_bn: {
                required: true,
                minlength: 3
            }
            
        },
        messages: {
            code: {
                required:  'Provide a Biological Code Please'
            },
            code_non_bio: {
                required:  'Provide a Non-Biological Code Please'
            },
            name: {
                required:  'You must provide a name'
            },
            name_bn: {
                required:  'You must provide a name in Bengali'
            },
            division_id: {
                required: 'Select a Division Please'
            },
            district_id: {
                required: 'Select a District Please'
            }
        }
    });


    // Reset form
    $('#reset').on('click', function() {
        validator.resetForm();
    });

});
