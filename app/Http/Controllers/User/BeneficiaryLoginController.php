<?php namespace App\Http\Controllers\User;

use App\Http\Requests\BeneficiaryLoginRequest;
use App\Model\Program\Beneficiary\BeneficiaryAttachmentsModel;
use App\Model\Program\Beneficiary\BeneficiaryModel;
use App\Http\Controllers\Controller;
use App\Model\Program\Beneficiary\PassbookModel;
use App\Model\Setup\AllowanceProgramModel;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class BeneficiaryLoginController extends Controller
{

    public $lang;

    public function __construct()
    {
        $this->lang = Session::get("locale");
        if (!isset($this->lang)) {
            $this->lang = config('app.locale');
        }
    }

    public function index()
    {
        return view('beneficiary_user.beneficiary_login');
    }

    public function home()
    {
        $beneficiaryInfo = BeneficiaryModel::where('id', '=', Session::get('beneficiary_sys_id'))
            ->get(['id', 'attachment_applicant_photo_id']);
        $attachment_photo_id = $beneficiaryInfo[0]->attachment_applicant_photo_id;

        if ($attachment_photo_id != null) {
            $photoPath = BeneficiaryAttachmentsModel::where('id', '=', $attachment_photo_id)->pluck('file_path');
            $photo_path = $photoPath[0];
        } else {
            $photo_path = 'uploads/placeholder.png';
        }

        return view('beneficiary_user.beneficiary_portal', compact('photo_path'));
    }

    public function userlogincheck(BeneficiaryLoginRequest $request)
    {
        $name = 'name';
        if ($this->lang == 'bn') {
            $name = 'name_bn';
        }

        $beneficiary_id = trim($request->input('beneficiary_id'));
        $password = md5($request->input('password'));

        $result = BeneficiaryModel::where('beneficiary_id', '=', $beneficiary_id)
            ->where('password', '=', $password)
            ->lists($name, 'id');

        $recordFound = count($result);

        try {
            if ($recordFound > 0) {

                foreach ($result as $key => $item) {
                    Session::put('beneficiary_sys_id', $key);
//                    Session::put('beneficiary_name', $item);

                    $beneficiary = BeneficiaryModel::where('id', '=', $key)
                        ->get(['name', 'name_bn']);
                    Session::put('beneficiary_name', $beneficiary[0]->name);
                    Session::put('beneficiary_name_bn', $beneficiary[0]->name_bn);
                }

//                return redirect('portal');
                return redirect('beneficiaryprofile');
            } else {
                throw new \Exception(trans('users/user_portal.lbl_wrong_input'));
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }

    public function getBeneficiaryInfo($id)
    {

        $nid = "'NID - '";
        $bris = "'BRIS - '";
        $country = "'Bangladeshi'";
        $name = 'name';
        if ($this->lang == 'bn') {
            $nid = "'জাতীয় পরিচিতি নম্বর - '";
            $bris = "'জন্মনিবন্ধন নম্বর - '";
            $country = "'বাংলাদেশী'";
            $name = 'name_bn';
        }

        $beneficiary = BeneficiaryModel::where('id', '=', Session::get('beneficiary_sys_id'))
            ->get(['id', 'allowance_program_id']);
        $program_id = $beneficiary[0]->allowance_program_id;

        $sql = "SELECT

                  b.id,
                  b.validity_id,
                  b.beneficiary_id,
                  b.validation_type,
                  wp.name AS program_name_en,
                  wp.name_bn AS program_name_bn,
                  b.name,
                  b.name_bn,
                  b.mother_name,
                  b.father_name,
                  b.spouse_name,

                  CASE WHEN b.validation_type = 'NID'
                  THEN CONCAT({$nid}, b.validity_id)
                  ELSE CONCAT({$bris},b.validity_id)
                  END AS validity_id_no,

                  per_div.name_bn per_div,
                  per_dis.name_bn per_dis,
                  per_thana.name_bn per_thana,
                  per_union.name_bn per_union,
                  per_union_ward.name_bn per_union_ward,
                  b.permanent_village,

                  per_div.geo_code AS per_div_geo_code,
                  per_dis.geo_code AS per_dis_geo_code,
                  per_thana.geo_code AS per_thana_geo_code,
                  per_union.geo_code AS per_union_geo_code,
                  per_union_ward.geo_code AS per_union_ward_geo_code,

                  pre_div.name_bn AS pre_div,
                  pre_dis.name_bn pre_dis,
                  pre_thana.name_bn pre_thana,
                  per_city.name AS per_city_corp_pau,
                  pre_union.name_bn pre_union,
                  pre_union_ward.name_bn pre_union_ward,
                  b.present_village,

                  pre_div.geo_code AS pre_div_geo_code,
                  pre_dis.geo_code AS pre_dis_geo_code,
                  pre_thana.geo_code AS pre_thana_geo_code,
                  pre_city.name AS pre_city_corp_pau,
                  pre_union.geo_code AS pre_union_geo_code,
                  pre_union_ward.geo_code AS pre_union_ward_geo_code,

                  b.contact_telephone_mobile AS mobile,
                  b.contact_email,
                  $country AS nationality,
                  '' AS ethnic_group,
                  '' AS particular_community,
                  DATE_FORMAT(b.date_of_birth,'%d-%m-%Y') AS date_of_birth,
                  birth_dis.name_bn AS birth_dis,
                  birth_thana.name_bn AS birth_thana,
                  religion.$name AS religion,
                  gender.$name AS gender,
                  cc_beneficiary_maritial_status.$name AS maritial_status,
                  cc_beneficiary_educational_status.$name AS educational_qualification,
                  cc_beneficiary_occupation.$name AS profession,
                  cc_beneficiary_annual_income.$name AS annual_income,
                  cc_beneficiary_health_working_ability_related_information.$name AS health_condition,
                  cc_beneficiary_description_of_benefit_from_government_private.$name AS govt_non_govt_benefit,
                  cc_beneficiary_residence.$name AS resident,
                  cc_beneficiary_land_ownership.$name AS own_land,
                  b.nominee_name,
                  b.nominee_nid,
                  b.nominee_address,
                  DATE_FORMAT(b.nominee_date_of_birth,'%d-%m-%Y') AS nominee_date_of_birth,
                  b.nominee_relations,
                  nominee_signature.file_path AS attachment_nominee_signature_id,
                  nominee_photo.file_path AS attachment_nominee_photo_id,
                  applicant_signature.file_path AS attachment_applicant_signature_id,
                  applicant_photo.file_path AS attachment_applicant_photo_id,
                  b.bank_account_no,
                  b.bank_account_title,
                  banks.$name AS bank_name,
                  bank_branches.$name AS branches_name,
                  DATE_FORMAT(b.first_benefit_received_date,'%d-%m-%Y') AS first_benefit_received_date,
                  DATE_FORMAT(b.last_benefit_received_date,'%d-%m-%Y') AS last_benefit_received_date,
                  b.monthly_amount,
                  fy.year_range AS financial_year,
                  b.passbook_no,
                  DATE_FORMAT(b.beneficiary_death_date,'%d-%m-%Y') AS beneficiary_death_date

                FROM beneficiaries b
                LEFT JOIN allowance_programs wp ON b.allowance_program_id = wp.id
                LEFT JOIN divisions pre_div ON b.present_division_id = pre_div.id
                LEFT JOIN divisions per_div ON b.permanent_division_id = per_div.id
                LEFT JOIN districts pre_dis ON b.present_district_id = pre_dis.id
                LEFT JOIN districts per_dis ON b.permanent_district_id = per_dis.id
                LEFT JOIN thana_upazilas pre_thana ON b.present_thana_upazila_id = pre_thana.id
                LEFT JOIN thana_upazilas per_thana ON b.permanent_thana_upazila_id = per_thana.id
                LEFT JOIN city_corp_paurasavas pre_city ON b.permanent_city_paurasavas_id = pre_city.id
                LEFT JOIN city_corp_paurasavas per_city ON b.permanent_city_paurasavas_id = per_city.id
                LEFT JOIN union_wards pre_union ON b.present_union_ward_id = pre_union.id
                LEFT JOIN union_wards per_union ON b.permanent_union_ward_id = per_union.id
                LEFT JOIN wards pre_union_ward ON b.present_ward_id = pre_union_ward.id
                LEFT JOIN wards per_union_ward ON b.permanent_ward_id = per_union_ward.id
                LEFT JOIN districts birth_dis ON b.birth_place_district_id = birth_dis.id
                LEFT JOIN thana_upazilas birth_thana ON b.birth_place_thana_upazila_id = birth_thana.id
                LEFT JOIN banks ON b.bank_id =banks.id
                LEFT JOIN cc_beneficiary_religion religion ON religion.id = b.cc_religion_id
                LEFT JOIN cc_genders gender ON gender.id = b.cc_gender_id
                LEFT JOIN bank_branches ON b.bank_branch_id=bank_branches.id
                LEFT JOIN financial_years fy ON fy.id=b.financial_year_id
                LEFT JOIN attachment_benificiaries AS applicant_photo ON b.attachment_applicant_photo_id = applicant_photo.id
                LEFT JOIN attachment_benificiaries AS applicant_signature ON b.attachment_applicant_signature_id = applicant_signature.id
                LEFT JOIN attachment_benificiaries AS nominee_photo ON nominee_photo.id = b.attachment_nominee_photo_id
                LEFT JOIN attachment_benificiaries AS nominee_signature ON nominee_signature.id = b.attachment_nominee_signature_id";

        if ($program_id == 1) {
            $sql .= " LEFT JOIN beneficiary_old_age AS sh ON sh.beneficiaries_id = b.id
                    LEFT JOIN cc_beneficiary_annual_income ON cc_beneficiary_annual_income.id = sh.annual_income
                    LEFT JOIN cc_beneficiary_land_ownership ON cc_beneficiary_land_ownership.id = sh.land_ownership
                    LEFT JOIN cc_beneficiary_health_working_ability_related_information ON cc_beneficiary_health_working_ability_related_information.id = sh.health_working_ability_related_information
                    LEFT JOIN cc_beneficiary_description_of_benefit_from_government_private ON cc_beneficiary_description_of_benefit_from_government_private.id = sh.description_of_benefit_from_government_private
                    LEFT JOIN cc_beneficiary_occupation ON cc_beneficiary_occupation.id = sh.occupation
                    LEFT JOIN cc_beneficiary_residence ON cc_beneficiary_residence.id = sh.residence
                    LEFT JOIN cc_beneficiary_educational_status ON cc_beneficiary_educational_status.id = sh.educational_status
                    LEFT JOIN cc_beneficiary_maritial_status ON cc_beneficiary_maritial_status.id = sh.maritial_status ";
        } else if ($program_id == 2) {
            $sql .= " LEFT JOIN beneficiary_old_age AS sh ON sh.beneficiaries_id = b.id
                    LEFT JOIN cc_beneficiary_annual_income ON cc_beneficiary_annual_income.id = sh.annual_income
                    LEFT JOIN cc_beneficiary_land_ownership ON cc_beneficiary_land_ownership.id = sh.land_ownership
                    LEFT JOIN cc_beneficiary_health_working_ability_related_information ON cc_beneficiary_health_working_ability_related_information.id = sh.health_working_ability_related_information
                    LEFT JOIN cc_beneficiary_description_of_benefit_from_government_private ON cc_beneficiary_description_of_benefit_from_government_private.id = sh.description_of_benefit_from_government_private
                    LEFT JOIN cc_beneficiary_occupation ON cc_beneficiary_occupation.id = sh.occupation
                    LEFT JOIN cc_beneficiary_residence ON cc_beneficiary_residence.id = sh.residence
                    LEFT JOIN cc_beneficiary_educational_status ON cc_beneficiary_educational_status.id = sh.educational_status
                    LEFT JOIN cc_beneficiary_maritial_status ON cc_beneficiary_maritial_status.id = sh.maritial_status ";
        } else {
            $sql .= " LEFT JOIN beneficiary_old_age AS sh ON sh.beneficiaries_id = b.id
                    LEFT JOIN cc_beneficiary_annual_income ON cc_beneficiary_annual_income.id = sh.annual_income
                    LEFT JOIN cc_beneficiary_land_ownership ON cc_beneficiary_land_ownership.id = sh.land_ownership
                    LEFT JOIN cc_beneficiary_health_working_ability_related_information ON cc_beneficiary_health_working_ability_related_information.id = sh.health_working_ability_related_information
                    LEFT JOIN cc_beneficiary_description_of_benefit_from_government_private ON cc_beneficiary_description_of_benefit_from_government_private.id = sh.description_of_benefit_from_government_private
                    LEFT JOIN cc_beneficiary_occupation ON cc_beneficiary_occupation.id = sh.occupation
                    LEFT JOIN cc_beneficiary_residence ON cc_beneficiary_residence.id = sh.residence
                    LEFT JOIN cc_beneficiary_educational_status ON cc_beneficiary_educational_status.id = sh.educational_status
                    LEFT JOIN cc_beneficiary_maritial_status ON cc_beneficiary_maritial_status.id = sh.maritial_status ";
        }

        $sql .= " WHERE b.id = '$id' ";

        $info = DB::select(DB::raw($sql));

        if('bn' == Session::get('locale')){
            $beneficiary_id = str_replace(
                array('1','2','3','4','5','6','7','8','9','0'),
                array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'),
                $info[0]->beneficiary_id
            );

            $validity_id = str_replace(
                array('1','2','3','4','5','6','7','8','9','0'),
                array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'),
                $info[0]->validity_id_no
            );

            $date_of_birth = str_replace(
                array('1','2','3','4','5','6','7','8','9','0'),
                array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'),
                $info[0]->date_of_birth
            );
            $mobile = str_replace(
                array('1','2','3','4','5','6','7','8','9','0'),
                array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০'),
                $info[0]->mobile
            );
        }else{
            $beneficiary_id = $info[0]->beneficiary_id;
            $validity_id = $info[0]->validity_id_no;
            $date_of_birth = $info[0]->date_of_birth;
            $mobile = $info[0]->mobile;
        }

        $info[0]->beneficiary_id = $beneficiary_id;
        $info[0]->validity_id_no = $validity_id;
        $info[0]->date_of_birth = $date_of_birth;
        $info[0]->mobile = $mobile;

        Session::put('program_name_en', $info[0]->program_name_en);
        Session::put('program_name_bn', $info[0]->program_name_bn);

        $passbook = PassbookModel::where('beneficiary_id', '=', $info[0]->beneficiary_id)
            //  ->get(['id', 'book_no', 'expense_bearer', 'account_title', 'main_account', 'auxiliary_account', 'issued_by', 'issue_date']);
            ->get();

        if (count($passbook) > 0) {
            $info[0]->expense_bearer = $passbook[0]->expense_bearer;
            $info[0]->account_title = $passbook[0]->account_title;
            $info[0]->main_account = $passbook[0]->main_account;
            $info[0]->auxiliary_account = $passbook[0]->auxiliary_account;
            $info[0]->issued_by = $passbook[0]->issued_by;
            $info[0]->issue_date = $passbook[0]->issue_date;
            $info[0]->received_by = $passbook[0]->received_by;
        } else {
            $info[0]->expense_bearer = '';
            $info[0]->account_title = '';
            $info[0]->main_account = '';
            $info[0]->auxiliary_account = '';
            $info[0]->issued_by = '';
            $info[0]->issue_date = '';
            $info[0]->received_by = '';
        }

        echo json_encode($info);
    }

    public function profile()
    {

        $beneficiaryInfo = BeneficiaryModel::where('id', '=', Session::get('beneficiary_sys_id'))
            ->get(['id', 'attachment_applicant_photo_id', 'attachment_nominee_photo_id']);
        $attachment_photo_id = $beneficiaryInfo[0]->attachment_applicant_photo_id;
        $nominee_photo_id = $beneficiaryInfo[0]->attachment_nominee_photo_id;

        if ($attachment_photo_id != null) {
            $photoPath = BeneficiaryAttachmentsModel::where('id', '=', $attachment_photo_id)->pluck('file_path');
            $photo_path = $photoPath[0];

        } else {
            $photo_path = 'uploads/placeholder.png';
        }

        if ($nominee_photo_id != null) {
            $nomineePhotoPath = BeneficiaryAttachmentsModel::where('id', '=', $nominee_photo_id)->firstOrFail();
            $nominee_photo_path = $nomineePhotoPath->file_path;
        } else {
            $nominee_photo_path = 'uploads/placeholder.png';
        }

        return view('beneficiary_user.profile', compact('photo_path', 'nominee_photo_path'));
    }

    public function passbookportal()
    {

        $beneficiaryInfo = BeneficiaryModel::where('id', '=', Session::get('beneficiary_sys_id'))
            ->get(['id', 'beneficiary_id', 'attachment_applicant_photo_id']);
        $beneficiary_id = $beneficiaryInfo[0]->beneficiary_id;

        if ($beneficiary_id != null && $beneficiaryInfo[0]->attachment_applicant_photo_id != null) {
            $photoPath = BeneficiaryAttachmentsModel::where('id', '=', $beneficiaryInfo[0]->attachment_applicant_photo_id)->pluck('file_path');
            $photo_path = $photoPath[0];
        } else {
            $photo_path = 'uploads/placeholder.png';
        }

        return view('beneficiary_user.passbook', compact('beneficiary_id', 'photo_path'));
    }

    public function getPassbookInfoForPortalByBeneficiaryID($id)
    {
        $name = 'name';
        $bname = 'name AS name';
        if ($this->lang == 'bn') {
            $name = 'name_bn';
            $bname = 'name_bn As name';
        }

        $beneficiaryInfo = BeneficiaryModel::where('beneficiary_id', '=', $id)
            ->get(['id', 'beneficiary_id', 'allowance_program_id', $bname, 'father_name', 'mother_name', 'validation_type', 'validity_id', 'date_of_birth', 'attachment_applicant_photo_id', 'passbook_no', 'bank_account_title', 'permanent_village', 'present_village']);

        if (count($beneficiaryInfo) != 0) {
            $beneficiaryInfo[0]['date_of_birth'] = date("d-m-Y", strtotime($beneficiaryInfo[0]['date_of_birth']));
            if ($beneficiaryInfo[0]['attachment_applicant_photo_id'] != null) {
                $photoPath = BeneficiaryAttachmentsModel::where('id', '=', $beneficiaryInfo[0]['attachment_applicant_photo_id'])->pluck('file_path');
                $beneficiaryInfo[0]['photo_path'] = $photoPath[0];
            } else {
                $beneficiaryInfo[0]['photo_path'] = 'uploads/placeholder.png';
            }
            $photoPath = AllowanceProgramModel::where('id', '=', $beneficiaryInfo[0]['allowance_program_id'])->firstOrFail();
            $beneficiaryInfo[0]['program_name_bn'] = $photoPath->$name;

            $passbook = PassbookModel::where('beneficiary_id', '=', $beneficiaryInfo[0]['beneficiary_id'])->get(['id', 'book_no', 'expense_bearer', 'account_title', 'main_account', 'auxiliary_account', 'issued_by', 'issue_date']);

            $bi = $beneficiaryInfo[0]->id;
        }

        $present_address_info = DB::select(DB::raw("SELECT  bi.id, bi.$name,
                bi.present_village, divisions.$name AS divisions, districts.$name AS districts,
                thana_upazilas.$name AS thana_upazila, city_corp_paurasavas.$name AS city_corp_paurasavas,
                union_wards.$name AS union_wards, wards.$name AS ward_name,
                bi.present_postal_code

                FROM
                beneficiaries bi
                LEFT JOIN divisions ON bi.present_division_id = divisions.id
                LEFT JOIN districts ON bi.present_district_id = districts.id
                LEFT JOIN thana_upazilas ON bi.present_thana_upazila_id = thana_upazilas.id
                LEFT JOIN city_corp_paurasavas ON bi.present_city_paurasavas_id = city_corp_paurasavas.id
                LEFT JOIN union_wards ON bi.present_union_ward_id = union_wards.id
                LEFT JOIN wards ON bi.present_ward_id = wards.id  WHERE bi.id = '$bi'"));

        $permanent_address_info = DB::select(DB::raw("SELECT  bi.id, bi.$name,
                bi.permanent_village, divisions.$name AS divisions, districts.$name AS districts,
                thana_upazilas.$name AS thana_upazila, city_corp_paurasavas.$name AS city_corp_paurasavas,
                union_wards.$name AS union_wards, wards.$name AS ward_name,
                bi.permanent_postal_code

                FROM
                beneficiaries bi
                LEFT JOIN divisions ON bi.permanent_division_id = divisions.id
                LEFT JOIN districts ON bi.permanent_district_id = districts.id
                LEFT JOIN thana_upazilas ON bi.permanent_thana_upazila_id = thana_upazilas.id
                LEFT JOIN city_corp_paurasavas ON bi.permanent_city_paurasavas_id = city_corp_paurasavas.id
                LEFT JOIN union_wards ON bi.permanent_union_ward_id = union_wards.id
                LEFT JOIN wards ON bi.permanent_ward_id = wards.id  WHERE bi.id = '$bi'"));

        $sql = "SELECT
                    ftb.monthly_amount AS monthly_amount, ftb.amount AS allotment_amount,
                    CONCAT(COALESCE(fyd.installment_title_bn,fyd.installment_title), ' (',DATE_FORMAT(fyd.period_from, '%b, %Y'), ' - ', DATE_FORMAT(fyd.period_to, '%b, %Y'), ')') AS installment_title_bn,
                    ap.name_bn AS allowence_bn, DATE_FORMAT(ftb.locked_date, '%d-%m-%Y') AS posting_date
                    ,b.passbook_no AS passbook_no

                    FROM
                    fund_transfers AS ft
                    LEFT JOIN fund_transfer_beneficiaries AS ftb ON ft.id = ftb.fund_transfer_id
                    LEFT JOIN beneficiaries AS b ON ftb.beneficiary_id = b.id
                    LEFT JOIN allowance_programs AS ap ON ap.id = ft.allocation_program_id
                    LEFT JOIN financial_year_installment_details AS fyd ON fyd.id = ft.installment_id
                    LEFT JOIN financial_year_installments AS fyi ON fyd.financial_year_installment_id = fyi.id
                    WHERE ftb.locked_date IS NOT NULL AND b.id = '$bi'";

        $passbookinfo = DB::select(DB::raw($sql));

        return view('beneficiary_user.passbookInfo', compact('beneficiaryInfo', 'passbook', 'present_address_info', 'permanent_address_info', 'passbookinfo'));
    }

    public function userlogout()
    {

        session_start();
        unset($_SESSION['beneficiary_sys_id']);
        unset($_SESSION['beneficiary_name']);
        session_destroy();
        return redirect('/beneficiaryuser');
    }
}
