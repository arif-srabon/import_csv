<?php

use Illuminate\Database\Seeder;

class DssProgramPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       /* $permissionData = [
            [
                'module' => 'Security',
                'description' => 'Role and User Section Permission',
                'section' => 'Manage User Role and Permission',
                'premission' => serialize([
                    'dss.security.role.view' => 'Allow view role and permission information (Menu access)',
                    'dss.security.role.add' => 'Add new role and permission information',
                    'dss.security.role.edit' => 'Update role and permission information',
                    'dss.security.role.del' => 'Delete role and permission information',
                    'dss.security.role.permission' => 'Allow to change role permission',

                ]),
                'weight' => '1'
            ],
            [
                'module' => 'Security',
                'description' => 'Role and User Section Permission',
                'section' => 'Manage User Account',
                'premission' => serialize([
                    'dss.security.users.view' => 'Allow view users information (Menu access)',
                    'dss.security.users.add' => 'Add new user information',
                    'dss.security.users.edit' => 'Update users information',
                    'dss.security.users.del' => 'Delete users information',
                    'dss.security.users.permission' => 'Allow to change role permission',
                ]),
                'weight' => '2'
            ],
            [
                'module' => 'Settings',
                'description' => 'Common Configuration',
                'section' => 'Manage Common Configuration ',
                'premission' => serialize([
                    'dss.settings.commonconfig.view' => 'Allow view common configuration (Menu access)',
                    'dss.settings.commonconfig.add' => 'Add new common configuration',
                    'dss.settings.commonconfig.edit' => 'Update common configuration',
                    'dss.settings.commonconfig.del' => 'Delete common configuration',
                ]),
                'weight' => '3'
            ],
            [
                'module' => 'Settings',
                'description' => 'Division information',
                'section' => 'Manage Division ',
                'premission' => serialize([
                    'dss.settings.division.view' => 'Allow view division (Menu access)',
                    'dss.settings.division.add' => 'Add new division',
                    'dss.settings.division.edit' => 'Update division',
                    'dss.settings.division.del' => 'Delete division',
                ]),
                'weight' => '4'
            ],
            [
                'module' => 'Settings',
                'description' => 'District information',
                'section' => 'Manage District',
                'premission' => serialize([
                    'dss.settings.district.view' => 'Allow view district (Menu access)',
                    'dss.settings.district.add' => 'Add new district',
                    'dss.settings.district.edit' => 'Update district',
                    'dss.settings.district.del' => 'Delete district',

                ]),
                'weight' => '5'
            ],
            [
                'module' => 'Settings',
                'description' => 'Thana / Upazilla information',
                'section' => 'Manage Thana / Upazilla',
                'premission' => serialize([
                    'dss.settings.thana_upazilla.view' => 'Allow view thana / upazilla (Menu access)',
                    'dss.settings.thana_upazilla.add' => 'Add new thana / upazilla',
                    'dss.settings.thana_upazilla.edit' => 'Update thana / upazilla',
                    'dss.settings.thana_upazilla.del' => 'Delete thana / upazilla',

                ]),
                'weight' => '6'
            ],
            [
                'module' => 'Settings',
                'description' => 'City Corp. / Paurasava information',
                'section' => 'Manage City Corp. / Paurasava',
                'premission' => serialize([
                    'dss.settings.city_corp_paurasava.view' => 'Allow view city corp. / paurasava (Menu access)',
                    'dss.settings.city_corp_paurasava.add' => 'Add new city corp. / paurasava',
                    'dss.settings.city_corp_paurasava.edit' => 'Update city corp. / paurasava',
                    'dss.settings.city_corp_paurasava.del' => 'Delete city corp. / paurasava',

                ]),
                'weight' => '7'
            ],
            [
                'module' => 'Settings',
                'description' => ' Union / Ward  information',
                'section' => 'Manage  Union / Ward ',
                'premission' => serialize([
                    'dss.settings.union_ward.view' => 'Allow view  union / ward  (Menu access)',
                    'dss.settings.union_ward.add' => 'Add new  union / ward ',
                    'dss.settings.union_ward.edit' => 'Update  union / ward ',
                    'dss.settings.union_ward.del' => 'Delete  union / ward ',

                ]),
                'weight' => '8'
            ],
            [
                'module' => 'Settings',
                'description' => ' Union Ward  information',
                'section' => 'Manage  Union Ward ',
                'premission' => serialize([
                    'dss.settings.unionward.view' => 'Allow view  union ward  (Menu access)',
                    'dss.settings.unionward.add' => 'Add new  union ward ',
                    'dss.settings.unionward.edit' => 'Update  union ward ',
                    'dss.settings.unionward.del' => 'Delete  union ward ',

                ]),
                'weight' => '9'
            ],
            [
                'module' => 'Settings',
                'description' => ' City Corp. Zone  information',
                'section' => 'Manage  City Corp. Zone ',
                'premission' => serialize([
                    'dss.settings.city_corp_zone.view' => 'Allow view  city corp. zone  (Menu access)',
                    'dss.settings.city_corp_zone.add' => 'Add new  city corp. zone ',
                    'dss.settings.city_corp_zone.edit' => 'Update  city corp. zone ',
                    'dss.settings.city_corp_zone.del' => 'Delete  city corp. zone ',

                ]),
                'weight' => '10'
            ],
            [
                'module' => 'Settings',
                'description' => 'Allowance Program  information',
                'section' => 'Manage Allowance Program ',
                'premission' => serialize([
                    'dss.settings.allowance_program.view' => 'Allow view allowance program   (Menu access)',
                    'dss.settings.allowance_program.add' => 'Add new allowance program ',
                    'dss.settings.allowance_program.edit' => 'Update allowance program ',
                    'dss.settings.allowance_program.del' => 'Delete allowance program ',

                ]),
                'weight' => '11'
            ],
            [
                'module' => 'Settings',
                'description' => 'Financial Year information',
                'section' => 'Manage Financial Year ',
                'premission' => serialize([
                    'dss.settings.financial_year.view' => 'Allow view financial year   (Menu access)',
                    'dss.settings.financial_year.add' => 'Add new financial year ',
                    'dss.settings.financial_year.edit' => 'Update financial year ',
                    'dss.settings.financial_year.del' => 'Delete financial year ',

                ]),
                'weight' => '12'
            ],
            [
                'module' => 'Settings',
                'description' => 'Installment  information',
                'section' => 'Manage Installment',
                'premission' => serialize([
                    'dss.settings.installment.view' => 'Allow view installment (Menu access)',
                    'dss.settings.installment.add' => 'Add new installment',
                    'dss.settings.installment.edit' => 'Update installment',
                    'dss.settings.installment.del' => 'Delete installment',
                    'dss.settings.installment.dtl.add' => 'Add New installment details',
                    'dss.settings.installment.dtl.edit' => 'Update installment details',
                    'dss.settings.installment.dtl.del' => 'Delete installment details',

                ]),
                'weight' => '13'
            ],
            [
                'module' => 'Settings',
                'description' => 'Bank information',
                'section' => 'Manage Bank',
                'premission' => serialize([
                    'dss.settings.bank.view' => 'Allow view bank (Menu access)',
                    'dss.settings.bank.add' => 'Add new bank',
                    'dss.settings.bank.edit' => 'Update bank',
                    'dss.settings.bank.del' => 'Delete bank',

                ]),
                'weight' => '14'
            ],
            [
                'module' => 'Settings',
                'description' => 'Bank Branch information',
                'section' => 'Manage Bank Branch',
                'premission' => serialize([
                    'dss.settings.bank_branch.view' => 'Allow view bank branch (Menu access)',
                    'dss.settings.bank_branch.add' => 'Add new bank branch',
                    'dss.settings.bank_branch.edit' => 'Update bank branch',
                    'dss.settings.bank_branch.del' => 'Delete bank branch',

                ]),
                'weight' => '15'
            ],
            [
                'module' => 'Settings',
                'description' => 'Selection Criteria information',
                'section' => 'Manage Selection Criteria',
                'premission' => serialize([
                    'dss.settings.selection_criteria.view' => 'Allow view selection criteria (Menu access)',
                    'dss.settings.selection_criteria.add' => 'Add new selection criteria',
                    'dss.settings.selection_criteria.edit' => 'Update selection criteria',
                    'dss.settings.selection_criteria.del' => 'Delete selection criteria',

                ]),
                'weight' => '16'
            ],
            [
                'module' => 'Settings',
                'description' => 'Exit Criteria information',
                'section' => 'Manage Exit Criteria',
                'premission' => serialize([
                    'dss.settings.exit_criteria.view' => 'Allow view exit criteria (Menu access)',
                    'dss.settings.exit_criteria.add' => 'Add new exit criteria',
                    'dss.settings.exit_criteria.edit' => 'Update exit criteria',
                    'dss.settings.exit_criteria.del' => 'Delete exit criteria',

                ]),
                'weight' => '17'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Office Management information',
                'section' => 'Office Management',
                'premission' => serialize([
                    'dss.transactions.office_management.view' => 'Allow view office management (Menu access)',
                    'dss.transactions.office_management.add' => 'Add new office management',
                    'dss.transactions.office_management.edit' => 'Update office management',
                    'dss.transactions.office_management.jurisdiction.view' => 'Allow view office jurisdiction',
                    'dss.transactions.office_management.office_user.view' => 'Allow view office users',
                    'dss.transactions.office_management.edit' => 'Update office management',
                    'dss.transactions.office_management.del' => 'Delete office management',

                ]),
                'weight' => '18'
            ],
            [
                'module' => 'Transactions',
                'description' => 'beneficiary table for allowance program information',
                'section' => 'Manage beneficiary table for allowance program',
                'premission' => serialize([
                    'dss.transactions.beneficiary_table_allowance_program.view' => 'Allow view beneficiary table for allowance program (Menu access)',
                    'dss.transactions.beneficiary_table_allowance_program.add' => 'Add new beneficiary table for allowance program',
                    'dss.transactions.beneficiary_table_allowance_program.edit' => 'Update beneficiary table for allowance program',
                    'dss.transactions.beneficiary_table_allowance_program.del' => 'Delete beneficiary table for allowance program',

                ]),
                'weight' => '19'
            ],
            [
                'module' => 'Transactions',
                'description' => 'beneficiary Common Configuration information',
                'section' => 'Manage beneficiary Common Configuration',
                'premission' => serialize([
                    'dss.transactions.beneficiary_common_configuration.view' => 'Allow view beneficiary common configuration (Menu access)',
                    'dss.transactions.beneficiary_common_configuration.add' => 'Add new beneficiary common configuration',
                    'dss.transactions.beneficiary_common_configuration.edit' => 'Update beneficiary common configuration',
                    'dss.transactions.beneficiary_common_configuration.del' => 'Delete beneficiary common configuration',

                ]),
                'weight' => '20'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Build beneficiary Form information',
                'section' => 'Manage Build beneficiary Form',
                'premission' => serialize([
                    'dss.transactions.build_beneficiary_form.view' => 'Allow view build beneficiary form (Menu access)',
                    'dss.transactions.build_beneficiary_form.add' => 'Add new build beneficiary form',
                    'dss.transactions.build_beneficiary_form.edit' => 'Update build beneficiary form',
                    'dss.transactions.build_beneficiary_form.del' => 'Delete build beneficiary form',

                ]),
                'weight' => '21'
            ],
            [
                'module' => 'Transactions',
                'description' => 'beneficiary Applicant information',
                'section' => 'Manage beneficiary Applicant',
                'premission' => serialize([
                    'dss.transactions.beneficiary_applicant.view' => 'Allow view beneficiary applicant (Menu access)',
                    'dss.transactions.beneficiary_applicant.add' => 'Add new beneficiary applicant',
                    'dss.transactions.beneficiary_applicant.edit' => 'Update beneficiary applicant',
                    'dss.transactions.beneficiary_applicant.del' => 'Delete beneficiary applicant',
                    'dss.transactions.beneficiary_applicant.preview' => 'Verified  beneficiary',
                    'dss.transactions.beneficiary_applicant.print_tracking' => 'Print tracking number',

                ]),
                'weight' => '22'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Beneficiary Criteria List',
                'section' => 'Manage Beneficiary Criteria List',
                'premission' => serialize([
                    'dss.transactions.beneficiary_criteria_list.view' => 'Allow view beneficiary criteria list (Menu access)',
                    'dss.transactions.beneficiary_criteria_list.add' => 'Add new beneficiary criteria list',
                    'dss.transactions.beneficiary_criteria_list.edit' => 'Update beneficiary criteria list',
                    'dss.transactions.beneficiary_criteria_list.del' => 'Delete beneficiary criteria list',
                    'dss.transactions.beneficiary_criteria_list.preview' => 'Preview  application',

                ]),
                'weight' => '23'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Beneficiary Application Verification by Union/Ward Committee',
                'section' => 'Manage Beneficiary Application Verification by Union/Ward Committee',
                'premission' => serialize([
                    'dss.transactions.beneficiary_applicant_verification_union_ward.view' => 'Allow view application verification by union/ward committee (Menu access)',
                    'dss.transactions.beneficiary_applicant_verification_union_ward.add' => 'Add new application verification by union/ward committee',
                    'dss.transactions.beneficiary_applicant_verification_union_ward.edit' => 'Update application verification by union/ward committee',
                    'dss.transactions.beneficiary_applicant_verification_union_ward.del' => 'Delete application verification by union/ward committee',
                    'dss.transactions.beneficiary_applicant_verification_union_ward.preview' => 'Preview  application',

                ]),
                'weight' => '24'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Beneficiary Application Verification by Upazila Committee',
                'section' => 'Manage Beneficiary Application Verification by Upazila Committee',
                'premission' => serialize([
                    'dss.transactions.beneficiary_applicant_verification_upazilla.view' => 'Allow view application verification by upazilla committee (Menu access)',
                    'dss.transactions.beneficiary_applicant_verification_upazilla.add' => 'Add new application verification by upazilla committee',
                    'dss.transactions.beneficiary_applicant_verification_upazilla.edit' => 'Update application verification by upazilla committee',
                    'dss.transactions.beneficiary_applicant_verification_upazilla.del' => 'Delete application verification by upazilla committee',
                    'dss.transactions.beneficiary_applicant_verification_upazilla.preview' => 'Preview  application',

                ]),
                'weight' => '25'
            ],
            [
                'module' => 'Transactions',
                'description' => 'beneficiary information',
                'section' => 'Manage beneficiary',
                'premission' => serialize([
                    'dss.transactions.beneficiary.view' => 'Allow view beneficiary (Menu access)',
                    'dss.transactions.beneficiary.add' => 'Add new beneficiary',
                    'dss.transactions.beneficiary.edit' => 'Update beneficiary',
                    'dss.transactions.beneficiary.del' => 'Delete beneficiary',
                    'dss.transactions.beneficiary.verification' => 'Verified  beneficiary',
                    'dss.transactions.beneficiary.print' => 'Print beneficiary',

                ]),
                'weight' => '26'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Passbook information',
                'section' => 'Manage Passbook',
                'premission' => serialize([
                    'dss.transactions.passbook.view' => 'Allow view Passbook (Menu access)',
                    'dss.transactions.passbook.add' => 'Add new Passbook',
                    'dss.transactions.passbook.edit' => 'Update Passbook',
                    'dss.transactions.passbook.del' => 'Delete Passbook',

                ]),
                'weight' => '27'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Complaint Information',
                'section' => 'Manage Complaint',
                'premission' => serialize([
                    'dss.transactions.complaint.view' => 'Allow view Complaint (Menu access)',
                    'dss.transactions.complaint.add' => 'Add new Complaint',
                    'dss.transactions.complaint.edit' => 'Update Complaint',
                    'dss.transactions.complaint.del' => 'Delete Complaint',
                    'dss.transactions.complaint.verification' => 'Verified  Complaint',
                    'dss.transactions.complaint.print' => 'Print Complaint',

                ]),
                'weight' => '28'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Common lock information',
                'section' => 'Manage Common lock',
                'premission' => serialize([
                    'dss.transactions.common_lock.view' => 'Allow view common lock (Menu access)',
                ]),
                'weight' => '29'
            ],
            [
                'module' => 'Allotment',
                'description' => 'Allocation of Allotment',
                'section' => 'Manage  Allocation of Allotment',
                'premission' => serialize([
                    'dss.allotment.allocation.view' => 'Allow view allocation of allotment (Menu access)',
                    'dss.allotment.allocation.add' => 'Add new allocation of allotment',
                    'dss.allotment.allocation.edit' => 'Update allocation of allotment',
                    'dss.allotment.allocation.del' => 'Delete allocation of allotment',
                    'dss.allotment.allocation.print' => 'Print allocation of allotment',
                ]),
                'weight' => '1'
            ],
            [
                'module' => 'Allotment',
                'description' => 'Disbursement of Allocation',
                'section' => 'Manage Disbursement of Allocation',
                'premission' => serialize([
                    'dss.allotment.disbursement.view' => 'Allow view disbursement of allocation (Menu access)',
                    'dss.allotment.disbursement.add' => 'Add new disbursement of allocation',
                    'dss.allotment.disbursement.edit' => 'Update disbursement of allocation',
                    'dss.allotment.disbursement.del' => 'Delete disbursement of allocation',
                    'dss.allotment.disbursement.posting' => 'Posting disbursement of allocation',
                    'dss.allotment.disbursement.print' => 'Print disbursement of allocation',
                    'dss.allotment.disbursement.notification_print' => 'Print disbursement of allocation notification',
                ]),
                'weight' => '2'
            ],

            [
                'module' => 'Allotment',
                'description' => 'Fund Transfer to Beneficiary',
                'section' => 'Manage Fund Transfer to Beneficiary',
                'premission' => serialize([
                    'dss.allotment.fundtransfer.view' => 'Allow view fund transfer to beneficiary (Menu access)',
                    'dss.allotment.fundtransfer.add' => 'Add new fund transfer to beneficiary',
                    'dss.allotment.fundtransfer.edit' => 'Update fund transfer to beneficiary',
                    'dss.allotment.fundtransfer.del' => 'Delete fund transfer to beneficiary',
                    'dss.allotment.fundtransfer.posting' => 'Posting fund transfer to beneficiary',
                    'dss.allotment.fundtransfer.print' => 'Print fund transfer to beneficiary',
                ]),
                'weight' => '3'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Committee Template Information',
                'section' => 'Manage Committee Template',
                'premission' => serialize([
                    'dss.transactions.committee.template.view' => 'Allow view Committee (Menu access)',
                    'dss.transactions.committee.template.add' => 'Add new Committee',
                    'dss.transactions.committee.template.edit' => 'Update Committee',
                    'dss.transactions.committee.template.del' => 'Delete Committee',

                ]),
                'weight' => '30'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Committee Member Information',
                'section' => 'Manage Committee Member',
                'premission' => serialize([
                    'dss.transactions.committee.member.view' => 'Allow view Committee Member (Menu access)',
                    'dss.transactions.committee.member.add' => 'Add new Committee Member',
                    'dss.transactions.committee.member.edit' => 'Update Committee Member',
                    'dss.transactions.committee.member.del' => 'Delete Committee Member',

                ]),
                'weight' => '31'
            ],
            [
                'module' => 'Transactions',
                'description' => 'Meeting Management Information',
                'section' => 'Manage Meeting Management',
                'premission' => serialize([
                    'dss.transactions.meeting.management.view' => 'Allow view Meeting Management (Menu access)',
                    'dss.transactions.meeting.management.add' => 'Add new Meeting Management',
                    'dss.transactions.meeting.management.edit' => 'Update Meeting Management',
                    'dss.transactions.meeting.management.del' => 'Delete Meeting Management',
                    'dss.transactions.meeting.resolution.add' => 'Add new Meeting Resolution',
                    'dss.transactions.meeting.resolution.edit' => 'Update Meeting Resolution',
                    'dss.transactions.meeting.resolution.del' => 'Delete Meeting Resolution',

                ]),
                'weight' => '32'
            ],

            [
                'module' => 'Transactions',
                'description' => 'Application Archive Information',
                'section' => 'Application Archives',
                'premission' => serialize([
                    'dss.archive.application_verification_by_union.view' => 'Allow view Archive Application Verification by Union (Menu access)',
                    'dss.archive.application_verification_by_upazila.view' => 'Allow view Archive Application Verification by Upazila (Menu access)',
                ]),
                'weight' => '33'
            ],

            [
                'module' => 'Reports',
                'description' => 'Applicant Information Reports',
                'section' => 'Applicant Reports',
                'premission' => serialize([
                    'dss.reports.applicant.beneficiary_application_list_1.view' => 'Allow view Report Beneficiary Application List-1 (Menu access)',
                    'dss.reports.applicant.beneficiary_application_list_2.view' => 'Allow view Report Beneficiary Application List-2 (Menu access)',
                    'dss.reports.applicant.beneficiary_application_list_3.view' => 'Allow view Report Beneficiary Application List-3 (Menu access)',
                    'dss.reports.applicant.beneficiary_application_list_4.view' => 'Allow view Report Beneficiary Application List-4 (Menu access)'
                ]),
                'weight' => '1'
            ],

            [
                'module' => 'Reports',
                'description' => 'Beneficiary Information Reports',
                'section' => 'Beneficiary Reports',
                'premission' => serialize([
                    'dss.reports.beneficiary.beneficiary_list.view' => 'Allow view Report Beneficiary List (Menu access)',
                    'dss.reports.beneficiary.beneficiary_summary.view' => 'Allow view Report Beneficiary Summary (Menu access)',
                    'dss.reports.beneficiary.passbook.view' => 'Allow view Report Passbook (Menu access)',
                    'dss.reports.beneficiary.beneficiary_bank_list.view' => 'Allow view Report Beneficiary Bank List (Menu access)',
                    'dss.reports.beneficiary.beneficiary_replacement.view' => 'Allow view Report Beneficiary Replacement (Menu access)',
                ]),
                'weight' => '2'
            ],
            [
                'module' => 'Reports',
                'description' => 'Allotment Information Reports',
                'section' => 'Allotment Reports',
                'premission' => serialize([
                    'dss.reports.allotment.installment_disbursement.view' => 'Allow view Report Installment wise Fund Disbursement (Menu access)',
                    'dss.reports.allotment.fund_transfer_summary.view' => 'Allow view Report Fund Transfer Summary (Menu access)',
                    'dss.reports.allotment.fund_transfer_details.view' => 'Allow view Report Fund Transfer Details (Menu access)',
                    'dss.reports.allotment.division_disbursement.view' => 'Allow view Report Division wise Fund Disbursement (Menu access)',
                    'dss.reports.allotment.district_disbursement_sum.view' => 'Allow view Report District wise Fund Disbursement (Menu access)',
                    'dss.reports.allotment.bank_disbursement.view' => 'Allow view Report Bank wise Fund Disbursement (Menu access)',
                ]),
                'weight' => '3'
            ],
            [
                'module' => 'Reports',
                'description' => 'Complaint Information Reports',
                'section' => 'Complaint Reports',
                'premission' => serialize([
                    'dss.reports.complaint.view' => 'Allow view Report Complaint (Menu access)'
                ]),
                'weight' => '4'
            ],
        ];*/

        $permissionData = [
            [
                'module'      => 'Security',
                'description' => ' ভূমিকা ও ইউজার অনুচ্ছেদ অনুমতি/Role and User Section Permission',
                'section'     => ' ব্যবহারকারী ভূমিকা এবং অনুমতি পরিচালনা/Manage User Role and Permission',
                'premission'  => serialize([
                    'dss.security.role.view'       => ' ভূমিকা এবং অনুমতি তথ্য (মেনু অ্যাক্সেস) মঞ্জুর করুন /Allow view role and permission information (Menu access)',
                    'dss.security.role.add'        => ' নতুন ভূমিকা এবং অনুমতি তথ্য যোগ করুন/Add new role and permission information',
                    'dss.security.role.edit'       => ' আপডেট ভূমিকা এবং অনুমতি তথ্য/Update role and permission information',
                    'dss.security.role.del'        => ' ভূমিকা এবং অনুমতি তথ্য মুছে ফেলুন/Delete role and permission information',
                    'dss.security.role.permission' => ' ভূমিকা অনুমতি পরিবর্তন করার মঞ্জুর করুন /Allow to change role permission',
                ]),
                'weight' => '1'
            ],
            [
                'module'      => 'Security',
                'description' => ' ভূমিকা ও ইউজার অনুচ্ছেদ অনুমতি/Role and User Section Permission',
                'section'     => ' ব্যবহারকারীর অ্যাকাউন্ট পরিচালনা/Manage User Account',
                'premission'  => serialize([
                    'dss.security.users.view'       => ' ব্যবহারকারীদের তথ্য(মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view users information (Menu access)',
                    'dss.security.users.add'        => ' নতুন ব্যবহারকারীর তথ্য যোগ করুন/Add new user information',
                    'dss.security.users.edit'       => ' আপডেট ব্যবহারকারীদের তথ্য/Update users information',
                    'dss.security.users.del'        => ' ব্যবহারকারীদের তথ্য মুছে ফেলুন/Delete users information',
                    'dss.security.users.permission' => ' ভূমিকা অনুমতি পরিবর্তন করার মঞ্জুর করুন /Allow to change role permission',
                ]),
                'weight' => '2'
            ],
            [
                'module'      => 'Settings',
                'description' => ' সাধারণ কনফিগারেশন/Common Configuration',
                'section'     => ' সাধারণ কনফিগারেশন পরিচালনা/Manage Common Configuration ',
                'premission'  => serialize([
                    'dss.settings.commonconfig.view' => 'সাধারণ কনফিগারেশন (মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view common configuration (Menu access)',
                    'dss.settings.commonconfig.add'  => ' নতুন সাধারণ কনফিগারেশন করুন/Add new common configuration',
                    'dss.settings.commonconfig.edit' => ' আপডেট সাধারণ কনফিগারেশন/Update common configuration',
                    'dss.settings.commonconfig.del'  => ' সাধারণ কনফিগারেশন মুছে ফেলুন/Delete common configuration',
                ]),
                'weight' => '3'
            ],
            [
                'module'      => 'Settings',
                'description' => ' বিভাগ তথ্য/Division information',
                'section'     => ' বিভাগ পরিচালনা/Manage Division ',
                'premission'  => serialize([
                    'dss.settings.division.view' => ' বিভাগ (মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view division (Menu access)',
                    'dss.settings.division.add'  => ' নতুন বিভাগ যোগ করুন/Add new division',
                    'dss.settings.division.edit' => ' আপডেট বিভাগ/Update division',
                    'dss.settings.division.del'  => ' বিভাগ মুছে ফেলুন/Delete division',
                ]),
                'weight' => '4'
            ],
            [
                'module'      => 'Settings',
                'description' => ' জেলা তথ্য/District information',
                'section'     => ' জেলা পরিচালনা/Manage District',
                'premission'  => serialize([
                    'dss.settings.district.view' => '  জেলা (মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view district (Menu access)',
                    'dss.settings.district.add'  => ' নতুন জেলা যোগ করুন/Add new district',
                    'dss.settings.district.edit' => ' আপডেট জেলা/Update district',
                    'dss.settings.district.del'  => ' জেলা মুছে ফেলুন/Delete district',

                ]),
                'weight' => '5'
            ],
            [
                'module'      => 'Settings',
                'description' => ' থানা / উপজেলা তথ্য/Thana / Upazilla information',
                'section'     => ' থানা / উপজেলা পরিচালনা/Manage Thana / Upazilla',
                'premission'  => serialize([
                    'dss.settings.thana_upazilla.view' => ' থানা / উপজেলা (মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view thana / upazilla (Menu access)',
                    'dss.settings.thana_upazilla.add'  => ' নতুন থানা / উপজেলার যোগ করুন/Add new thana / upazilla',
                    'dss.settings.thana_upazilla.edit' => ' আপডেট থানা / উপজেলা/Update thana / upazilla',
                    'dss.settings.thana_upazilla.del'  => ' থানা / উপজেলা মুছে ফেলুন/Delete thana / upazilla',

                ]),
                'weight' => '6'
            ],
            [
                'module'      => 'Settings',
                'description' => '  ইউনিয়নের ওয়ার্ড তথ্য/Union Ward  information',
                'section'     => ' ইউনিয়নের ওয়ার্ড পরিচালনা/Manage  Union Ward ',
                'premission'  => serialize([
                    'dss.settings.unionward.view' => ' ইউনিয়নের ওয়ার্ড (মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view  union ward  (Menu access)',
                    'dss.settings.unionward.add'  => ' নতুন ইউনিয়ন ওয়ার্ড যোগ করুন/Add new  union ward ',
                    'dss.settings.unionward.edit' => ' আপডেট ইউনিয়নের ওয়ার্ড/Update  union ward ',
                    'dss.settings.unionward.del'  => ' ইউনিয়ন ওয়ার্ড মুছে ফেলুন/Delete  union ward ',

                ]),
                'weight' => '9'
            ],
            [
                'module'      => 'Settings',
                'description' => ' কার্যক্রম প্রোফাইল তথ্য/Allowance Program  information',
                'section'     => ' কার্যক্রম প্রোফাইল পরিচালনা/Manage Allowance Program ',
                'premission'  => serialize([
                    'dss.settings.allowance_program.view' => ' কার্যক্রম প্রোফাইল(মেনু অ্যাক্সেস)মঞ্জুর করুন/Allow view allowance program   (Menu access)',
                    'dss.settings.allowance_program.add'  => ' নতুন কার্যক্রম প্রোফাইল যোগ করুন/Add new allowance program ',
                    'dss.settings.allowance_program.edit' => ' আপডেট কার্যক্রম প্রোফাইল/Edit/Update allowance program ',
                    'dss.settings.allowance_program.del'  => ' কার্যক্রম প্রোফাইল মুছে ফেলুন/Delete allowance program ',

                ]),
                'weight' => '11'
            ],
            [
                'module'      => 'Settings',
                'description' => ' Manufacturer / Company',
                'section'     => 'Manufacturer / Company',
                'premission'  => serialize([
                    'settings.manufacturer.view' => 'Allow view Manufacturer / Company (Menu access)',
                    'settings.manufacturer.add'  => 'Add new Manufacturer / Company',
                    'settings.manufacturer.edit' => 'Edit/Update Manufacturer / Company',
                    'settings.manufacturer.del'  => 'Delete Manufacturer / Company',

                ]),
                'weight' => '12'
            ],
            [
                'module'      => 'Settings',
                'description' => 'Brand / Medicine',
                'section'     => 'Brand / Medicine',
                'premission'  => serialize([
                    'settings.medicine.view' => 'Allow view Brand / Medicine (Menu access)',
                    'settings.medicine.add'  => 'Add new Brand / Medicine',
                    'settings.medicine.edit' => 'Edit/Update Brand / Medicine',
                    'settings.medicine.del'  => 'Delete Brand / Medicine',

                ]),
                'weight' => '13'
            ],
            [
                'module'      => 'Transactions',
                'description' => 'ADR Reporting',
                'section'     => 'ADR Reporting',
                'premission'  => serialize([
                    'transactions.adrreporting.view'  => 'Allow view ADR Reporting (Menu access)',
                    'transactions.adrreporting.add'   => 'Add new ADR Reporting',
                    'transactions.adrreporting.edit'  => 'Edit/Update ADR Reporting',
                    //'transactions.adrreporting.del'   => 'Delete ADR Reporting',
                    'transactions.adrreporting.print' => 'Print ADR Reporting',

                ]),
                'weight' => '14'
            ],
            [
                'module'      => 'Transactions',
                'description' => 'Complaint Information',
                'section'     => 'Complaint Information',
                'premission'  => serialize([
                    'transactions.complaint.view'  => 'Allow view Complaint Information (Menu access)',
                    'transactions.complaint.print' => 'Print Complaint Information',
                    'transactions.complaint.edit'  => 'Edit/Update Complaint Information',
                ]),
                'weight' => '15'
            ],
            [
                'module'      => 'Transactions',
                'description' => 'Counterfeit / Fake Medicine / Medical Device',
                'section'     => 'Counterfeit / Fake Medicine / Medical Device',
                'premission'  => serialize([
                    'transactions.counterfeit.view'  => 'Allow view Counterfeit Reporting (Menu access)',
                    'transactions.counterfeit.add'   => 'Add new Counterfeit Reporting',
                    'transactions.counterfeit.edit'  => 'Update Counterfeit Reporting',
                    'transactions.counterfeit.del'   => 'Delete Counterfeit Reporting',
                    'transactions.counterfeit.print' => 'Print Counterfeit Reporting',

                ]),
                'weight' => '16'
            ],
            [
                'module'      => 'Transactions',
                'description' => 'News and Events',
                'section'     => 'News and Events',
                'premission'  => serialize([
                    'transactions.news.view' => 'Allow view News and Events (Menu access)',
                    'transactions.news.add' => 'Add new News and Events',
                    'transactions.news.edit' => 'Update News and Events',
                    'transactions.news.del' => 'Delete News and Events',

                ]),
                'weight' => '17'
            ],
            [
                'module'      => 'Manufacturer',
                'description' => 'Unique Number Generation Information',
                'section'     => 'Unique Number Generation Information',
                'premission'  => serialize([
                    'manufacturer.uniquenumber.view' => 'Allow view Unique Number Generation (Menu access)',
                    'manufacturer.uniquenumber.add' => 'Add new Unique Number Generation',
                    'manufacturer.uniquenumber.edit' => 'Update Unique Number Generation',
                    'manufacturer.uniquenumber.del' => 'Delete Unique Number Generation',
                ]),
                'weight' => '18'
            ],
            [
                'module'      => 'Reports',
                'description' => 'Reports 1',
                'section'     => 'Reports 1',
                'premission'  => serialize([
                    'reports.testreport.view' => 'Allow view Report',

                ]),
                'weight' => '3'
            ],
            [
                'module'      => 'Web',
                'description' => 'Web 1',
                'section'     => 'Web 1',
                'premission'  => serialize([
                    'web.pages.view' => 'Allow view page 1',
                ]),
                'weight' => '1'
            ],


        ];


        /*
         * Insert Permission Data
         */
        DB::table('permissions')->truncate();
        foreach ($permissionData as $data) {
            DB::table('permissions')->insert([
                'module' => $data['module'],
                'description' => $data['description'],
                'section' => $data['section'],
                'premission' => $data['premission'],
                'weight' => $data['weight']
            ]);
        }
    }
}
