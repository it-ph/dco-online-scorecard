<?php

namespace App\Imports;

use App\User;
use App\Setting;
use App\Scorecard\tl as tlScoreCard;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TLScoresImport implements ToModel, WithHeadingRow, WithValidation,SkipsEmptyRows
{
    private $has_error = array();
    private $row_number = 1;
    public function model(array $row)
    {
        $ctr_error = 0;
        array_push($this->has_error,"Something went wrong, Please check all entries that you have encoded.");

        $teamlead = User::where('emp_id', $row['employee_number'])->where('role', 'supervisor')->where('status', 'active')->select('id','manager')->first();

        $this->row_number += 1;
        $month = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['month']))->format('M Y');
        if($teamlead->count() > 0)
        {
            // dd('found');
            $tl_id = $teamlead->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell B". $this->row_number.", ". "Employee Number: ". $row['employee_number']. " not exist.");
            $ctr_error += 1;
        }


        $productivity = $this->removePercent($row['productivity']);
        $productivity_actual_remarks = $this->removePercent($row['productivity_actual_remarks']);
        $productivity_self_assessment_rating = $this->removePercent($row['productivity_self_assessment_rating']);
        
        $quality = $this->removePercent($row['quality']);
        $quality_actual_remarks = $this->removePercent($row['quality_actual_remarks']);
        $quality_self_assessment_rating = $this->removePercent($row['quality_self_assessment_rating']);

        $partnership = $this->removePercent($row['partnership']);
        $partnership_actual_remarks = $this->removePercent($row['partnership_actual_remarks']);
        $partnership_self_assessment_rating = $this->removePercent($row['partnership_self_assessment_rating']);

        $no_client_escalations = $this->removePercent($row['no_client_escalations']);
        $no_client_escalations_actual_remarks = $this->removePercent($row['no_client_escalations_actual_remarks']);
        $no_client_escalations_self_assessment_rating = $this->removePercent($row['no_client_escalations_self_assessment_rating']);

        $no_pay_dispute = $this->removePercent($row['no_pay_dispute']);
        $no_pay_dispute_actual_remarks = $this->removePercent($row['no_pay_dispute_actual_remarks']);
        $no_pay_dispute_self_assessment_rating = $this->removePercent($row['no_pay_dispute_self_assessment_rating']);

        $attrition = $this->removePercent($row['attrition']);
        $attrition_actual_remarks = $this->removePercent($row['attrition_actual_remarks']);
        $attrition_self_assessment_rating = $this->removePercent($row['attrition_self_assessment_rating']);

        $linkedin_learning_compliance = $this->removePercent($row['linkedin_learning_compliance']);
        $linkedin_learning_compliance_actual_remarks = $this->removePercent($row['linkedin_learning_compliance_actual_remarks']);
        $linkedin_learning_compliance_self_assessment_rating = $this->removePercent($row['linkedin_learning_compliance_self_assessment_rating']);

        $eod_reporting = $this->removePercent($row['eod_reporting']);
        $eod_reporting_actual_remarks = $this->removePercent($row['eod_reporting_actual_remarks']);
        $eod_reporting_self_assessment_rating = $this->removePercent($row['eod_reporting_self_assessment_rating']);

        $htl_compliance = $this->removePercent($row['htl_compliance']);
        $htl_compliance_actual_remarks = $this->removePercent($row['htl_compliance_actual_remarks']);
        $htl_compliance_self_assessment_rating = $this->removePercent($row['htl_compliance_self_assessment_rating']);

        $other_compliances_required = $this->removePercent($row['other_compliances_required']);
        $other_compliances_required_actual_remarks = $this->removePercent($row['other_compliances_required_actual_remarks']);
        $other_compliances_required_self_assessment_rating = $this->removePercent($row['other_compliances_required_self_assessment_rating']);

        $reliability = $this->removePercent($row['reliability']);
        $reliability_actual_remarks = $this->removePercent($row['reliability_actual_remarks']);
        $reliability_self_assessment_rating = $this->removePercent($row['reliability_self_assessment_rating']);

        $target = Setting::where('setting','target')->first();

        $final_score = number_format(($productivity + $quality + $partnership +
                                    $reliability + $no_client_escalations + $no_pay_dispute + $attrition +
                                    $linkedin_learning_compliance +
                                    $eod_reporting + 
                                    $htl_compliance + 
                                    $other_compliances_required ), 2);

        if($ctr_error <= 0)
        {
            tlScoreCard::updateOrCreate(
                [
                    'tl_id' => $tl_id,
                    'month' => $month,
                ],
                [
                    'target' => $target->value,
                    'quality' => $quality,
                    'quality_actual_remarks' => $quality_actual_remarks,
                    'quality_self_assessment_rating' => $quality_self_assessment_rating,

                    'productivity' => $productivity,
                    'productivity_actual_remarks' => $productivity_actual_remarks,
                    'productivity_self_assessment_rating' => $productivity_self_assessment_rating,

                    'partnership' => $partnership,
                    'partnership_actual_remarks' => $partnership_actual_remarks,
                    'partnership_self_assessment_rating' => $partnership_self_assessment_rating,

                    'no_client_escalations' => $no_client_escalations,
                    'no_client_escalations_actual_remarks' => $no_client_escalations_actual_remarks,
                    'no_client_escalations_self_assessment_rating' => $no_client_escalations_self_assessment_rating,

                    'attrition' => $attrition,
                    'attrition_actual_remarks' => $attrition_actual_remarks,
                    'attrition_self_assessment_rating' => $attrition_self_assessment_rating,

                    'no_pay_dispute' => $no_pay_dispute,
                    'no_pay_dispute_actual_remarks' => $no_pay_dispute_actual_remarks,
                    'no_pay_dispute_self_assessment_rating' => $no_pay_dispute_self_assessment_rating,

                    'linkedin_learning_compliance' => $linkedin_learning_compliance,
                    'linkedin_learning_compliance_actual_remarks' => $linkedin_learning_compliance_actual_remarks,
                    'linkedin_learning_compliance_self_assessment_rating' => $linkedin_learning_compliance_self_assessment_rating,

                    'eod_reporting' => $eod_reporting,
                    'eod_reporting_actual_remarks' => $eod_reporting_actual_remarks,
                    'eod_reporting_self_assessment_rating' => $eod_reporting_self_assessment_rating,

                    'htl_compliance' => $htl_compliance,
                    'htl_compliance_actual_remarks' => $htl_compliance_actual_remarks,
                    'htl_compliance_self_assessment_rating' => $htl_compliance_self_assessment_rating,

                    'other_compliances_required' => $other_compliances_required,
                    'other_compliances_required_actual_remarks' => $other_compliances_required_actual_remarks,
                    'other_compliances_required_self_assessment_rating' => $other_compliances_required_self_assessment_rating,

                    'reliability' => $reliability,
                    'reliability_actual_remarks' => $reliability_actual_remarks,
                    'reliability_self_assessment_rating' => $reliability_self_assessment_rating,

                    'final_score' => $final_score,
                    'new_manager_id' => $teamlead->manager,
                ]
            );
        }
    }

    public function getErrors()
    {
        return $this->has_error;
    }

    public function removePercent($val)
    {
        $a =  str_replace("%","",$val);
        $b = str_replace("%","",$a);

        return $b;
    }

    public function rules(): array
    {
        return [
            '*.month' => ['required'],
            '*.employee_number' => ['required'],
            '*.employee_name' => ['required'],
            '*.quality' => ['required'],
            '*.partnership' => ['required'],
            '*.no_client_escalations' => ['required'],
            '*.attrition' => ['required'],
            '*.no_pay_dispute' => ['required'],
            '*.linkedin_learning_compliance' => ['required'],
            '*.eod_reporting' => ['required'],
            '*.htl_compliance' => ['required'],
            '*.other_compliances_required' => ['required'],
            '*.reliability' => ['required'],
        ];
    }
}
