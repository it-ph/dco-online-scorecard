<?php

namespace App\Imports;

use App\User;
use App\Setting;
use App\Scorecard\Agent as agentScoreCard;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScoresImport implements ToModel, WithHeadingRow, WithValidation,SkipsEmptyRows
{
    private $has_error = array();
    private $row_number = 1;
    public function model(array $row)
    {
        $ctr_error = 0;
        array_push($this->has_error,"Something went wrong, Please check all entries that you have encoded.");

        $agent = User::where('emp_id', $row['employee_number'])->where('role', 'agent')->where('status', 'active')->select('id','supervisor','manager')->first();

        // dd($agent);
        $this->row_number += 1;

        if(strtolower($row['month_type']) == 'mid' || strtolower($row['month_type']) == 'end')
        {
            $month_type = $row['month_type'];
        }
        else
        {
            array_push($this->has_error, "Check Cell A". $this->row_number.", ". "Month Type: ". $row['month_type']. " is invalid.");
            $ctr_error += 1;
        }

        if($agent->count() > 0)
        {
            // dd('found');
            $agent_id = $agent->id;
        }
        else
        {
            array_push($this->has_error, "Check Cell C". $this->row_number.", ". "Employee Number: ". $row['employee_number']. " not exist.");
            $ctr_error += 1;
        }

        $month = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['month']))->format('M Y');

        $actual_productivity = $this->removePercent($row['productivity']);
        $productivity_remarks = $this->removePercent($row['productivity_remarks']);
        $productivity_self_assessment_rating = $this->removePercent($row['productivity_self_assessment_rating']);

        $actual_quality = $this->removePercent($row['quality']);
        $quality_remarks = $this->removePercent($row['quality_remarks']);
        $quality_self_assessment_rating = $this->removePercent($row['quality_self_assessment_rating']);

        $actual_reliability = $this->removePercent($row['reliability']);
        $reliability_remarks = $this->removePercent($row['reliability_remarks']);
        $reliability_self_assessment_rating = $this->removePercent($row['reliability_self_assessment_rating']);

        $actual_profit= $this->removePercent($row['profit']);
        $profit_remarks = $this->removePercent($row['profit_remarks']);
        $profit_self_assessment_rating = $this->removePercent($row['profit_self_assessment_rating']);

        $actual_engagement= $this->removePercent($row['engagement']);
        $engagement_remarks = $this->removePercent($row['engagement_remarks']);
        $engagement_self_assessment_rating = $this->removePercent($row['engagement_self_assessment_rating']);

        $actual_behavior= $this->removePercent($row['behavior']);
        $behavior_remarks = $this->removePercent($row['behavior_remarks']);
        $behavior_self_assessment_rating = $this->removePercent($row['behavior_self_assessment_rating']);

        $actual_partnership= $this->removePercent($row['partnership']);
        $partnership_remarks = $this->removePercent($row['partnership_remarks']);
        $partnership_self_assessment_rating = $this->removePercent($row['partnership_self_assessment_rating']);

        $actual_priority= $this->removePercent($row['priority']);
        $priority_remarks = $this->removePercent($row['priority_remarks']);
        $priority_self_assessment_rating = $this->removePercent($row['priority_self_assessment_rating']);

        $target = Setting::where('setting','target')->first();
        $p = Setting::where('setting','productivity')->first();
        $q = Setting::where('setting','quality')->first();
        $r = Setting::where('setting','reliability')->first();
        $pt = Setting::where('setting','profit')->first();
        $e = Setting::where('setting','engagement')->first();
        $b = Setting::where('setting','behavior')->first();
        $ps = Setting::where('setting','partnership')->first();
        $py = Setting::where('setting','priority')->first();

        $productivity = number_format((($p->value / 100) * $actual_productivity), 2);
        $quality = number_format((($q->value / 100) * $actual_quality), 2);
        $reliability = number_format((($r->value / 100) * $actual_reliability), 2);
        $profit = number_format((($pt->value / 100) * $actual_profit), 2);
        $engagement = number_format((($e->value / 100) * $actual_engagement), 2);
        $behavior = number_format((($b->value / 100) * $actual_behavior), 2);
        $partnership = number_format((($ps->value / 100) * $actual_partnership), 2);
        $priority = number_format((($py->value / 100) * $actual_priority), 2);

        $productivity = $productivity > $p->value ? number_format($p->value, 2) : $productivity;
        $quality = $quality > $q->value ? number_format($q->value, 2) : $quality;
        $reliability = $reliability > $r->value ? number_format($r->value, 2) : $reliability;
        $profit = $profit > $pt->value ? number_format($pt->value, 2) : $profit;
        $engagement = $engagement > $e->value ? number_format($e->value, 2) : $engagement;
        $partnership = $partnership > $ps->value ? number_format($ps->value, 2) : $partnership;
        $priority = $priority > $py->value ? number_format($py->value, 2) : $priority;

        $final_score = number_format(($productivity + $quality + $reliability + $profit + $engagement + $partnership + $priority), 2);

        if($ctr_error <= 0)
        {
            agentScoreCard::updateOrCreate(
                [
                    'agent_id' => $agent_id,
                    'month_type' => $month_type,
                    'month' => $month,
                ],
                [
                    'target' => $target->value,

                    'actual_productivity' => $actual_productivity,
                    'productivity_remarks' => $productivity_remarks,
                    'productivity_self_assessment_rating' => $productivity_self_assessment_rating,

                    'actual_quality' => $actual_quality,
                    'quality_remarks' => $quality_remarks,
                    'quality_self_assessment_rating' => $quality_self_assessment_rating,

                    'actual_reliability' => $actual_reliability,
                    'reliability_remarks' => $reliability_remarks,
                    'reliability_self_assessment_rating' => $reliability_self_assessment_rating,

                    'actual_profit' => $actual_profit,
                    'profit_remarks' => $profit_remarks,
                    'profit_self_assessment_rating' => $profit_self_assessment_rating,

                    'actual_engagement' => $actual_engagement,
                    'engagement_remarks' => $engagement_remarks,
                    'engagement_self_assessment_rating' => $engagement_self_assessment_rating,

                    'actual_behavior' => $actual_behavior,
                    'behavior_remarks' => $behavior_remarks,
                    'behavior_self_assessment_rating' => $behavior_self_assessment_rating,

                    'actual_partnership' => $actual_partnership,
                    'partnership_remarks' => $partnership_remarks,
                    'partnership_self_assessment_rating' => $partnership_self_assessment_rating,

                    'actual_priority' => $actual_priority,
                    'priority_remarks' => $priority_remarks,
                    'priority_self_assessment_rating' => $priority_self_assessment_rating,

                    'productivity' => $productivity,
                    'quality' => $quality,
                    'reliability' => $reliability,
                    'profit' => $profit,
                    'engagement' => $engagement,
                    'behavior' => $behavior,
                    'partnership' => $partnership,

                    'priority' => $priority,
                    'priority_remarks' => $priority_remarks,
                    'priority_self_assessment_rating' => $priority_self_assessment_rating,

                    'final_score' => $final_score,
                    'acknowledge_by_agent' => 0,
                    'date_acknowledge_by_agent' => null,
                    'acknowledge_by_tl' => 0,
                    'new_tl_id' => $agent->supervisor,
                    'date_acknowledge_by_tl' => null,
                    'acknowledge_by_manager' => 0,
                    'new_manager_id' => $agent->manager,
                    'date_acknowledge_by_manager' => null,
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
            '*.productivity' => ['required'],
            '*.reliability' => ['required'],
            '*.profit' => ['required'],
            '*.engagement' => ['required'],
            '*.behavior' => ['required'],
            '*.partnership' => ['required'],
            '*.priority' => ['required']
        ];
    }
}
