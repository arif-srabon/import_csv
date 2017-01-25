/**
 * Created by Arif on 1/16/2017.
 */
/**
 * Created by Arif on 9/21/2016.
 */
/* ------------------------------------------------------------------------------
 *
 *  # Form validation for Guiding Resources
 *
 *
 * ---------------------------------------------------------------------------- */

$(function () {


    // Form components
    // ------------------------------
    $("#logo_image").change(function () {
        previewImage(this, 'preview_image');
    });//end files

    // Styled file input
    $(".file-styled").uniform({
        wrapperClass: 'bg-teal-400',
        fileButtonHtml: '<i class="icon-googleplus5"></i>'
    });
    //

    // Setup validation
    jQuery.validator.addMethod("dateBD", function (value, element) {
        // valid date format DD-MM-YYYY
        return this.optional(element) || /^(0?[1-9]|[12][0-9]|3[01])[\-](0?[1-9]|1[012])[\-]\d{4}$/.test(value);
    }, 'Please Enter a Valid Date.');
    // ------------------------------
    // Initialize
    var validator = $("#frmImport").validate({
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

        },
        messages: {
        }
    });

});
