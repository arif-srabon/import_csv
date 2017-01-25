/* ------------------------------------------------------------------------------
*
*  # Form validation for idsc center
*
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Form components
    // ------------------------------

    // Styled checkboxes, radios
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice' });

    // Styled file input
    $(".file-styled").uniform({
        wrapperClass: 'bg-teal-400',
        fileButtonHtml: '<i class="icon-googleplus5"></i>'
    });
	
	
	$('.daterange-single').daterangepicker({
        autoUpdateInput: false,
        singleDatePicker: true,
        "autoApply": true,
        locale: {
            cancelLabel: 'Clear',
            format: 'DD-MM-YYYY'
        }
    });

    $('.daterange-single').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
    });
	
	  // Click to edit
    // ------------------------------

    // Edit
    $('#edit').on('click', function() {
        $('.click2edit').summernote({focus: true});
    })

    // Save
    $('#save').on('click', function() {
        var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
		//console.log(aHTML);
		$('#hidNewsBody').val(aHTML);
        $('.click2edit').destroy();
    })


    // Setup validation
    // ------------------------------
    // date format validation
    jQuery.validator.addMethod("dateBD", function(value, element) {
        // valid date format DD-MM-YYYY
        return this.optional( element ) ||  /^(0?[1-9]|[12][0-9]|3[01])[\-](0?[1-9]|1[012])[\-]\d{4}$/.test( value );
    }, 'Please enter a valid date.');

    // Initialize
    var validator = $("#frm_news").validate({
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
            title: {
                required: true,
            },
            published_dt: {
                required: true,
				dateBD:true
            } 
        },
        messages: {
            
        }
    });


    // Reset form
    $('#reset').on('click', function() {
        validator.resetForm();
    });

});
