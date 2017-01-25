<?php


return [
    'num_paging_row'    => 10,
    'grid_page_sizes'   => [5, 10, 15, 20,],
    'grid_button_count' => 5,
    'grid_height'       => 500,
    'grid_height_small' =>350,

    //status value for magic number
    'is_active_true' => 1,
    'online_user'    => 1,

    'user_upload_photo_path'     => 'uploads/user/photo/',
    'medicine_upload_photo_path' => 'uploads/medicine/',
    'import_file_path' => 'uploads/importFile/',

    //location type
    'location_type_union'            =>1,
    'location_type_city_corporation' =>2,
    'location_type_paurasava'        =>3,

    /*
    * DB active status
    */
    'db_active'   => 1,
    'db_inactive' => 0,

    /*
     * cache parameter
     */
    'cache_time_limit' => 5, // 5 minutes

    /*
     * Common Message
     */
    'msg_delete_confirmation'       => "Are you sure you want to delete the selected record?",
    'msg_save'                      => "Data Saved Successfully",
    'msg_update'                    => "Data Updated Successfully",
    'msg_upload'                    => "Data has been Uploaded Successfully",
    'msg_delete'                    => "Data Deleted Successfully",
    'msg_invalid_input'             => "Invalid/Duplicate Input Data, Check Again",
    'msg_failed_delete'             => "Data Deleted Failed",
    'msg_verification_confirmation' => "Are you sure you want to verify?",
    'msg_duplicate'                 => "Duplicate Data Found, Try Another Caption",
    'msg_transfer_confirmation'     => "Are you sure you want to transfer the selected record?",
    'msg_transfer'                  => "Applicant Transfered Successfully",
    'msg_transfer_failed'           => "Applicant Transfered Failed",
    'msg_complaint_confirmation'    => "Are you sure want to Submit the Complaint?",
    'msg_application_confirmation'  => "Are you sure you want to submit this application?",

    'toastr_error'   => 'error',
    'toastr_success' => 'success',
    'toastr_warning' => 'warning',
    'toastr_info'    => 'info',

    'cityCorp'                    => 2,
    'yearly'                      => 1,
    'quarterly'                   => 4,
    'monthly'                     => 12,
    'halfYearly'                  => 2,
    'complainer_type_beneficiary' => 1,

    //upload path set
    'allowance_program_upload_path' => 'uploads/allowance_program/',

    //ADR Reporting | Adverse Effect | Adverse Effect Outcome
    'adverse_effect_outcome_fatal_id' => 5,

    //Counterfeit Reporting | Incident & Product Details | Incident Type
    'counterfeit_incident_type_other_id' => 5,

    //Complaint Default Status
    'complaint_default_status_id' => 1, //open

    //ADR/Counterfeit Default Status
    'adr_default_status_id' => 1, //open

    // Web user default role
    'web_user_role' => 17,

];
