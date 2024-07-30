<?php


use App\Scorecard\Agent as agentScoreCard;
use App\Scorecard\tl as TLScoreCard;

//Self: Agent
function agentHasUnAcknowledgeCard()
{
    return agentScoreCard::agentdetails( Auth::user()->id )->where('acknowledge_by_agent',0)->count();
}

//Self: TL
function tlHasUnAcknowledgeCard()
{
    return TLScoreCard::tldetails( Auth::user()->id )->where('acknowledge',0)->count();
}

//Team: TL / Manager, Agent members
function memberUnacknowledgeCard($position)
{
    return agentScoreCard::where('acknowledge_by_tl',0)
    ->agentsuperior($position,Auth::user()->id)
   ->count();
}

//Team: Manager, TL members
function memberTLUnacknowledgeCard()
{
    return TLScoreCard::where('acknowledge',0)
    ->Tlsuperior('manager',Auth::user()->id)
   ->count();
}



//All: Agent
function allAgentUnacknowledgeCard()
{
    return agentScoreCard::where('acknowledge_by_agent',0)->count();
}

//All: TL
function allTLUnacknowledgeCard()
{
    return TLScoreCard::where('acknowledge',0)->count();
}

function allUnAcknowledgeCard()
{
    $agent = agentScoreCard::where('acknowledge',0)->count();
    $tl = TLScoreCard::where('acknowledge',0)->count();

    return ($agent + $tl);
}

// function getAgentScore($agent_id, $month)
// {
//     $agent_score = agentScoreCard::where('agent_id', $agent_id)->where('month', $month)->value('final_score');

//     $agent_score = $agent_score <> null ? number_format($agent_score, 2) : '';

//     return $agent_score;
// }

function getAgentScore($agent_id, $month, $period)
{
    $agent_score = agentScoreCard::query()
        ->where('agent_id', $agent_id)
        ->where('month_type', $period)
        ->where('month', $month)
        ->select('actual_quality', 'productivity', 'actual_reliability', 'actual_profit', 'actual_people','actual_engagement','actual_behavior','actual_partnership','actual_priority','final_score')
        ->first();


    if($agent_score)
    {
        // $score_quality = $agent_score->quality; //implement new quality performance range july 20, 2022
        $score_quality = getAgentQualityScore($agent_score->actual_quality);
        $score_productivity = $agent_score->productivity;
        $score_reliability = getAgentReliabilityScore($agent_score->actual_reliability);
        $score_profit = getAgentProfitScore($agent_score->actual_profit);
        /*$score_people = getAgentPeopleScore($agent_score->actual_people); */
        $score_behavior = getAgentPeopleBehScore($agent_score->actual_behavior);
        $score_engagement = getAgentPeopleEngScore($agent_score->actual_engagement);
        $score_partnership = getAgentPartnershipScore($agent_score->actual_partnership);
        $score_priority = getAgentPriorityScore($agent_score->actual_priority);
        
        $agent_score = $score_quality + $score_productivity + $score_reliability + $score_profit + $score_engagement + $score_behavior + $score_partnership + $score_priority;

        $agent_score = $agent_score <> null ? number_format($agent_score, 2) : '';

        return $agent_score;
    }
    else
    {
        return '';
    }

}

function getTlScore($tl_id, $month)
{
    $tl_score = TLScoreCard::query()
        ->where('tl_id', $tl_id)
        ->where('month', $month)
        ->select('final_score')
        ->first();

    if($tl_score)
    {
        $tlscores = $tl_score->final_score <> null ? number_format($tl_score->final_score, 2) : '';

        return $tlscores;
    }
    else
    {
        return '';
    }

}

function removeBraces($val)
{
    $a =  str_replace('["',"",$val);
    $b = str_replace('"]',"",$a);

    return $b;
}

/*  function getScore($score, $ranges)
{
    foreach ($ranges as $range => $value) {
        [$min, $max] = explode('-', $range);

        if ($score >= $min && $score <= $max) {
            return $value;
        }
    }

    return 0;
}

function getAgentQualityScore($score)
{

    $ranges = [
        '0-79.99' => 0,
        '80-84.99' => 10,
        '85-89.99' => 15,
        '90-94.99' => 20,
        '95-100' => 25,
    ];

    $rawScore = getScore($score, $ranges); // assuming getScore function exists
    return round($rawScore);
}

function getAgentProductivityScore($score)
{
     $ranges = [
        '0-79.99' => 0,
        '80-89.99' => 5,
        '90-100' => 12.5,
    ];
    $score *= 0.125;

    return $score;
}

function getAgentReliabilityScore($score)
{
    $ranges = [
        '0-79.99' => 0,
        '80-84.99' => 2,
        '85-89.99' => 5,
        '90-94.99' => 8,
        '95-100' => 12.5,
    ];

    return getScore($score, $ranges);
}

function getAgentProfitScore($score)
{
    $ranges = [
        '0' => 0,
        '5' => 5,
        '10' => 10,
    ];

    return getScore($score, $ranges);
}

function getAgentPeopleScore($score)
{
    $ranges = [
        '0-79.99' => 0,
        '80-84.99' => 5,
        '85-89.99' => 10,
        '90-94.99' => 15,
        '95-100' => 20,
    ];

    return getScore($score, $ranges);
}

function getAgentPeopleEngScore($score)
{
    $ranges = [
        '0' => 0,
        '15' => 15,
    ];

    return getScore($score, $ranges);
}

function getAgentPeopleBehScore($score)
{
    $ranges = [
        '4' => 0,
        '3' => 2,
        '2' => 5,
        '1' => 8,
        '0' => 10,
    ];

    return getScore($score, $ranges);
}

function getAgentPartnershipScore($score)
{
    $ranges = [
        '0' => 0,
        '5' => 5,
    ];

    return getScore($score, $ranges);
}

function getAgentPriorityScore($score)
{
    $ranges = [
        '4' => 0,
        '3' => 2,
        '2' => 5,
        '1' => 8,
    ];

    return getScore($score, $ranges);
}

function getTlReliabilityScore($score)
{
    $ranges = [
        '0-84.99' => 0,
        '85-95' => 5,
        '90-95' => 7,
        '95-100' => 10,
    ];

    return getScore($score, $ranges);
}  */


function getAgentQualityScore($score)
{
    if($score < 80)
    {
        $score = 0;
    }
    elseif($score >= 80 && $score <= 84.99)
    {
        $score = 5;
    }
    elseif($score >= 85 && $score <= 89.99)
    {
        $score = 15;
    }
    elseif($score >= 90 && $score <= 94.99)
    {
        $score = 20;
    }
    elseif($score >= 95)
    {
        $score = 25;
    }

    return $score;
}

function getAgentProductivityScore($score)
{
    if($score > 100)
    {
        $score = 12.5;
    }

    return (($score * 0.125) / 100) * 100;
}

function getAgentReliabilityScore($score)
{
    if($score < 80)
    {
        $score = 0;
    }
    elseif($score >= 80 && $score <= 84)
    {
        $score = 2;
    }
    elseif($score >= 85 && $score <= 89)
    {
        $score = 5;
    }
    elseif($score >= 90 && $score <= 94)
    {
        $score = 8;
    }
    elseif($score >= 95)
    {
        $score = 12.5;
    }

    return $score;
}

function getAgentProfitScore($score)
{
    if($score  == 0)
    {
        $score = 0;
    }
    elseif($score == 10)
    {
        $score = 10;
    }

    return ($score * 10) / 10;
}

function getAgentPeopleEngScore($score)
{
    if($score == 0)
    {
        $score = 0;
    }
    elseif($score == 15)
    {
        $score = 15;
    }

    return ($score * 10) / 10;
}

function getAgentPeopleBehScore($score)
{
    if($score == 0)
    {
        $score = 0;
    }
    elseif($score == 5)
    {
        $score = 5;
    }
    elseif($score == 10)
    {
        $score = 10;
    }

    return ($score * 10) / 10;
}

function getAgentPartnershipScore($score)
{
    if($score == 0)
    {
        $score = 0;
    }
    elseif($score == 5)
    {
        $score = 5;
    }

    return ($score * 10) / 10;
}

function getAgentPriorityScore($score)
{
    if($score == 0)
    {
        $score = 0;
    }
    elseif($score == 2)
    {
        $score = 2;
    }
    elseif($score == 5)
    {
        $score = 5;
    }
    elseif($score == 8)
    {
        $score = 8;
    }
    elseif($score == 10)
    {
        $score = 10;
    }

    return ($score * 10) / 10;

}

function getTlReliabilityScore($score)
{
    if($score < 85)
    {
        $score = 0;
    }
    elseif($score >= 85 && $score <= 95)
    {
        $score = 5;
    }
    elseif($score >= 90 && $score <= 95)
    {
        $score = 7;
    }
    elseif($score >= 95)
    {
        $score = 10;
    }

    return $score;
}




/* function getTlReliabilityScore($score)
{
    if($score < 85)
    {
        $score = 0;
    }
    elseif($score >= 85 && $score <= 95)
    {
        $score = 5;
    }
    elseif($score >= 90 && $score <= 95)
    {
        $score = 7;
    }
    elseif($score >= 95)
    {
        $score = 10;
    }

    return $score;
} */

