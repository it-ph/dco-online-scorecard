<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/dco-scorecard.css')}}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{asset('css/google.font.css')}}" > --}}
    <style>
        body {
            color: black;
        }

        table {
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;

        }

        .lbl-bold {
            font-weight: bold
        }

        .ttxt-center {
            text-align: center;
        }

        @media print {
            .noprint {
                display: none;
            }
        }

        @media print {
            .container { margin: 0; }
            table {
                font-size: 12px !important;
            }
        }

        .col-print-1 {
            width: 8%;
            float: left;
        }

        .col-print-2 {
            width: 16%;
            float: left;
        }

        .col-print-3 {
            width: 25%;
            float: left;
        }

        .col-print-4 {
            width: 33%;
            float: left;
        }

        .col-print-5 {
            width: 42%;
            float: left;
        }

        .col-print-6 {
            width: 50%;
            float: left;
        }

        .col-print-7 {
            width: 58%;
            float: left;
        }

        .col-print-8 {
            width: 66%;
            float: left;
        }

        .col-print-9 {
            width: 75%;
            float: left;
        }

        .col-print-10 {
            width: 83%;
            float: left;
        }

        .col-print-11 {
            width: 92%;
            float: left;
        }

        .col-print-12 {
            width: 100%;
            float: left;
        }
    </style>
    <title>DCO Scorecard</title>
</head>

<body>
    <div class="container">
        <div class="row noprint" style="margin-top: 15px;">
            <div class="col-md-12">
                <button type="button" title="Click to go back to Lists" class="btn btn-success btn-sm" onclick="goBack()"><i class="fa fa-chevron-left"></i> Back to Lists</button>
                <button type="button" title="Click to Print Scorecard" class="btn btn-info bt-sm pull-right" onclick="printThis()"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
        <div class="row" style="margin-top: 40px;">
            <div class="col-md-12">
                <table width="100%" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; text-align: center; font-weight: bold;font-size: 22px">@if($score->thetl->thedepartment)
                            {{strtoupper($score->thetl->thedepartment->department)}}
                            @endif - OPS SUPERVISOR</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Employee Name:</td>
                        <td>{{ucwords($score->thetl->name)}}</td>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 18px;"> FINAL SCORE</span> </td>
                        <?php
                    $totalkpis = $score->quality + $score->productivity + $score->reliability;
                    $score_remarks = $score->actual_remarks;

                    $quality_remarks = $score->quality_actual_remarks;
                    $quality_self_assessment_rating = $score->quality_self_assessment_rating;
                    $productivity_remarks = $score->productivity_actual_remarks;
                    $productivity_self_assessment_rating = $score->productivity_self_assessment_rating;
                    $reliability_remarks = $score->reliability_actual_remarks;
                    $reliability_self_assessment_rating = $score->reliability_self_assessment_rating;
                    $partnership_remarks = $score->partnership_actual_remarks;
                    $partnership_self_assessment_rating = $score->partnership_self_assessment_rating;
                    $profit_remarks = $score->profit_actual_remarks;
                    $profit_self_assessment_rating = $score->profit_self_assessment_rating;
                    $no_client_escalations_remarks = $score->no_client_escalations_actual_remarks;
                    $no_client_escalations_self_assessment_rating = $score->no_client_escalations_self_assessment_rating;
                    $attrition_remarks = $score->attrition_actual_remarks;
                    $attrition_self_assessment_rating = $score->attrition_self_assessment_rating;
                    $no_pay_dispute_remarks = $score->no_pay_dispute_actual_remarks;
                    $no_pay_dispute_self_assessment_rating = $score->no_pay_dispute_self_assessment_rating;
                    $linkedIn_learning_compliance_remarks = $score->linkedin_learning_compliance_actual_remarks;
                    $linkedIn_learning_compliance_self_assessment_rating = $score->linkedin_learning_compliance_self_assessment_rating;
                    $eod_reporting_remarks = $score->eod_reporting_actual_remarks;
                    $eod_reporting_self_assessment_rating = $score->eod_reporting_self_assessment_rating;
                    $htl_compliance_remarks = $score->htl_compliance_actual_remarks;
                    $htl_compliance_self_assessment_rating = $score->htl_compliance_self_assessment_rating;
                    $other_compliances_required_remarks = $score->other_compliances_required_actual_remarks;
                    $other_compliances_required_self_assessment_rating = $score->other_compliances_required_self_assessment_rating;

                    $priority_tl_requirements = $score->linkedin_learning_compliance + $score->eod_reporting + $score->htl_compliance; // eod, htl, linkedin learning

                    $totaldeliverables = $score->no_client_escalations + $score->no_pay_dispute + $score->other_compliances_required + $priority_tl_requirements + $score->partnership + $score->attrition;
                    // $final_reliablityscore = getTlReliabilityScore($score->reliability);
                    $final_score = $totalkpis + $totaldeliverables;
                        ?>
                        <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$final_score}}%</span></td>
                        <!-- <td rowspan="2" style="text-align: center;"><span style="font-weight: bold; font-size: 22px"> {{$score->final_score}}%</span></td> -->
                    </tr>

                    <tr>
                        <td class="lbl-bold">Emp ID:</td>
                        <td>{{$score->thetl->emp_id}}</td>

                    </tr>

                    <tr>
                        <td class="lbl-bold">Designation</td>
                        <td>{{ucwords($score->thetl->theposition->position)}}</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Line Manager</td>
                        <td>{{ ucwords($score->thetl->themanager->name) }}</td>
                        <td class="lbl-bold">Month of QTR / Year:</td>
                        <td>{{$score->month}}</td>
                    </tr>

                    <tr>
                        <td class="lbl-bold">Department</td>
                        <td>{{ucwords($score->thetl->thedepartment->department)}}</td>
                        <td class="lbl-bold">Target:</td>
                        <td>{{$score->target}}%</td>
                    </tr>
                </table>

            </div>
        </div>
        <!--row-->

        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="margin-top: 20px; font-size: 14px" cellspacing="5" cellpadding="5">
                    <tr style="background: gray; text-align: center; font-weight: bold;">
                        <td>KRA</td>
                        <td>GOAL</td>
                        <td>GOAL DESCRIPTION</td>
                        <td>KBA WEIGHTAGE</td>
                        <td>TARGET/PERFORMANCE RANGE</td>
                        <td>SELF ASSESSMENT RATING</td>
                        <td>EMPLOYEE REMARKS</td>
                        <td>ACTUAL SCORE</td>
                        <td>SCORE</td>
                    </tr>
                    <tr>
                    <!--start 1st column-->
                    <td rowspan="3" style="width: 200px" class="lbl-bold ttxt-center">Performance</td>
                    <td class="ttxt-center">Quality</td>
                    <td class="ttxt-center">LOB Quality Performance Score</td>
                    <td class="ttxt-center">20.00%</td>
                    <td style="text-align: center; width: 350px;  font-style: italic">
                        <span style="font-weight: 500">20%</span> -  95% above Quality average<br>
                        <span style="font-weight: 500">15%</span> -  90% to 94.99% above Quality average<br>
                        <span style="font-weight: 500">10%</span> -  85% to 89.99% above Quality average<br>
                        <span style="font-weight: 500">5%</span> -  80% to 84.99% above Quality average<br>
                        <span style="font-weight: 500">0%</span>  -  79.99% below Quality average</span>
                    </td>
                    <td class="ttxt-center">{{$quality_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$quality_remarks}}</td>
                    <!--end 1st column done-->

                    <td class="ttxt-center lbl-bold">{{$score->quality}}%</td>
                    <td rowspan="3" class="ttxt-center lbl-bold">{{$totalkpis}}%</td>
                </tr>
                <tr>
                    <!--start 2nd column-->
                    <td class="ttxt-center">Productivity</td>
                    <td class="ttxt-center">Overall Team Productivity</td>
                    <td class="ttxt-center">15.00%</td>
                    <td style="text-align: center;  width: 350px;  font-style: italic">100% Productivity Average</td>
                    <td class="ttxt-center">{{$productivity_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$productivity_remarks}}</td>
                    <!--end 2nd column-->

                    <td class="ttxt-center lbl-bold">{{$score->productivity}}%</td>
                </tr>

                <tr>
                    <!--start 3rd column-->
                    <td class="ttxt-center">Reliability</td>
                    <td class="ttxt-center">Personal Attendance</td>
                    <td class="ttxt-center">10.00%</td>
                    <td style="text-align: center; width: 350px;  font-style: italic">
                        <span style="font-weight: 500">10.00%</span> -  95% above <br>
                        <span style="font-weight: 500">7%</span> -  90% to 94.99% <br>
                        <span style="font-weight: 500">5%</span> -  85% to 89.99% <br>
                        <span style="font-weight: 500">0%</span>  -  84.99% below </span>
                    </td>
                    <td class="ttxt-center">{{$reliability_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$reliability_remarks}}</td>
                    <!--end 3rd column-->

                    <td class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
                </tr>
                <tr>
                    <!--start 4th column-->
                    <td rowspan="2" style="width: 200px" class="lbl-bold ttxt-center">Profit</td>
                    <td class="ttxt-center">Escalation</td>
                    <td class="ttxt-center">No client escalation</td>
                    <td class="ttxt-center">15.00%</td>
                    <td style="text-align: center;  width: 350px;  font-style: italic">
                        <span style="font-weight: 500">0%</span> - With monetary impact <br>
                        <span style="font-weight: 500">7.50%</span> - No monetary impact <br>
                        <span style="font-weight: 500">15%</span> - No escalation </span>
                    </td>
                    <td class="ttxt-center">{{$no_client_escalations_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$no_client_escalations_remarks}}</td>
                    <!--end 4th column-->

                    <td class="ttxt-center lbl-bold">{{$score->no_client_escalations}}%</td>
                    <td rowspan="6" class="ttxt-center lbl-bold">{{$totaldeliverables}}%</td>
                </tr>
                <tr>
                    <!--start 4th column-->
                    <td class="ttxt-center">Attrition</td>
                    <td class="ttxt-center">Not more than 2% monthly attrition</td>
                    <td class="ttxt-center">10.00%</td>
                    <td style="text-align: center;  width: 350px;  font-style: italic">All or nothing</td>
                    <td class="ttxt-center">{{$attrition_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$attrition_remarks}}</td>
                    <!--end 4th column-->

                    <td class="ttxt-center lbl-bold">{{$score->attrition}}%</td>
                </tr>
                <tr>
                    <!--start 5th column-->
                    <td style="width: 200px" class="lbl-bold ttxt-center">People</td>
                    <td class="ttxt-center">Leadership survey</td>
                    <td class="ttxt-center">Survey score</td>
                    <td class="ttxt-center">5.00%</td>
                    <td style="text-align: center; width: 350px;  font-style: italic">
                        <span style="font-weight: 500">3.6 above</span> -  5% <br>
                        <span style="font-weight: 500">3.4</span> -  3.6% <br>
                        <span style="font-weight: 500">3.2</span> <br>
                        <span style="font-weight: 500">Below</span>  -  3.0% </span>
                    </td>
                    <td class="ttxt-center">{{$no_pay_dispute_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$no_pay_dispute_remarks}}</td>
                    <!--end 5th column-->

                    <td class="ttxt-center lbl-bold">{{$score->no_pay_dispute}}%</td>

                </tr>
                <tr>
                    <!--start 5th column-->
                    <td style="width: 200px" class="lbl-bold ttxt-center">Partnership</td>
                    <td class="ttxt-center">Engagement</td>
                    <td class="ttxt-center">Team's participation</td>
                    <td class="ttxt-center">5.00%</td>
                    <td style="text-align: center; width: 350px;  font-style: italic">
                        <span>There should be a participation from your team member.</span>
                    </td>
                    <td class="ttxt-center">{{$partnership_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$partnership_remarks}}</td>
                    <!--end 5th column-->

                    <td class="ttxt-center lbl-bold">{{$score->partnership}}%</td>
                </tr>
                <tr>
                    <!--start 5th column-->
                    <td rowspan="2" style="width: 200px" class="lbl-bold ttxt-center">Priority</td>
                    <td class="ttxt-center">TL Requirements</td>
                    <td class="ttxt-center">HTL, EOD and linkedIn Learning.</td>
                    <td class="ttxt-center">15.00%</td>
                    <td style="text-align: center; width: 350px;  font-style: italic">
                        <span style="font-weight: 500">5%</span> - HTL <br>
                        <span style="font-weight: 500">5%</span> - EOD <br>
                        <span style="font-weight: 500">5%</span> - LinkedIn Learning <br>
                    </td>
                    <td class="ttxt-center">
                        <span>{{$htl_compliance_self_assessment_rating}}</span><br>
                        <span>{{$eod_reporting_self_assessment_rating}}</span><br>
                        <span>{{$linkedIn_learning_compliance_self_assessment_rating}}</span>
                    </td>
                    <td class="ttxt-center">
                        <span>{{$htl_compliance_remarks}}</span><br>
                        <span>{{$eod_reporting_remarks}}</span><br>
                        <span>{{$linkedIn_learning_compliance_remarks}}</span>
                    </td>
                    <!--end 5th column-->

                    <td class="ttxt-center lbl-bold">{{$priority_tl_requirements}}%</td>
                </tr>
                <tr>
                    <!--start 5th column-->
                    <td class="ttxt-center">Special Projects</td>
                    <td class="ttxt-center">Other TL Deliverables</td>
                    <td class="ttxt-center">5.00%</td>
                    <td style="text-align: center; width: 350px;  font-style: italic">
                        <span style="font-weight: 500"></span> Weights equally divided to the number of monthly tasks. <br>
                    </td>
                    <td class="ttxt-center">{{$other_compliances_required_self_assessment_rating}}</td>
                    <td class="ttxt-center">{{$other_compliances_required_remarks}}</td>
                    <!--end 5th column-->

                    <td class="ttxt-center lbl-bold">{{$score->other_compliances_required}}%</td>
                </tr>

<!--                     <tr>

                        <td style="width: 200px" class="lbl-bold ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td style="text-align: center; width: 350px;  font-style: italic"></td>
                        <td></td>
                        <td></td>
       

                        <td rowspan="4" style="width: 200px" class="lbl-bold ttxt-center">RELIABILITY <br> <span style="font-weight: normal">(Absenteeism, Tardiness, Overbreak, Undertime)</span></td>
                        <td rowspan="4" class="ttxt-center">10%</td>
                        <td rowspan="4" class="ttxt-center"><span>95% Over-all Reliability</span> </td>
                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                >95% reliability
                        </td>
                        <td class="ttxt-center lbl-bold">10%</td>
                        <td rowspan="4" class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
                        <td rowspan="4" class="ttxt-center lbl-bold">{{$score->reliability}}%</td>
                    </tr>
                    <tr>
            
                        <td style="width: 200px" class="lbl-bold ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td style="text-align: center; width: 350px;  font-style: italic"></td>
                        <td></td>
                        <td></td>
            

                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <95%>=90% reliability
                        </td>
                        <td class="ttxt-center lbl-bold">7%</td>
                    </tr>
                    <tr>
               
                        <td style="width: 200px" class="lbl-bold ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td style="text-align: center; width: 350px;  font-style: italic"></td>
                        <td></td>
                        <td></td>
          

                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <95%>=85% reliability
                        </td>
                        <td class="ttxt-center lbl-bold">5%</td>
                    </tr>
                    <tr>
        
                        <td style="width: 200px" class="lbl-bold ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td class="ttxt-center"></td>
                        <td style="text-align: center; width: 350px;  font-style: italic"></td>
                        <td></td>
                        <td></td>
             

                        <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                < 85% reliability </td> <td class="ttxt-center lbl-bold">0%</td>
                    </tr>-->
                    <tr>
                        <!--start 5th column-->
                        <td colspan="3" class="ttxt-center lbl-bold">Average</td>
                        <td class="ttxt-center lbl-bold">100%</td>
                        <td style="text-align: center; width: 350px;  font-style: italic"></td>
                        <td></td>
                        <td></td>
                        <!--end 5th column-->
                        
                        <td</td>
                        <td class="ttxt-center lbl-bold">TOTAL SCORE</td>
                        <td class="ttxt-center lbl-bold" style="font-size: 20px">{{$final_score}}%</td>
                    </tr>

                </table>
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->

        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; font-weight: bold">EMPLOYEE FEEDBACK:</td>
                    </tr>

                    <tr>
                        <td>
                            <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->feedback}}</textarea>
                        </td>
                    </tr>


                </table>

            </div>
            <!--col-md-12-->
        </div>
        <!--row-->

        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="margin-top: 40px; font-size: 14px; font-style: italic" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan="4" style="background: gray; font-weight: bold">ACTION PLAN/S:</td>
                    </tr>

                    <tr>
                        <td>
                            <textarea name="" id="" style="color: black; font-size: 12px; background: transparent; border: 0px" readonly cols="30" rows="10" class="form-control">{{$score->action_plan}}</textarea>
                        </td>
                    </tr>


                </table>

            </div>
            <!--col-md-12-->
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <!--row-->
        <div class="row" style="margin-top: 20px">
            <div class="col-print-2"></div>
            <div class="col-print-4 text-center">
                <span style="font-weight: bold;">
                    @if($score->date_acknowledge_by_tl)
                    <img src="{{ asset('storage')}}/{{ $score->thetlsignature->user_id }}/signatures/{{$score->thetlsignature->file}}" alt="">
                    <br><i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> <small>{{ date('m/d/Y h:i:s a', strtotime($score->date_acknowledge_by_tl)) }}</small>
                    @else
                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                    @endif
                </span><br>
                <span style="text-decoration: underline; font-weight: bold;">{{strtoupper($score->thetl->name)}}</span>
                <br> <span style="font-weight: normal;font-size: 14px">Team Leader</span> </p>
            </div>
            <!--col-md-5-->

            <div class="col-print-6 text-center" @if($score->date_acknowledge_by_tl) style="margin-top: 98px" @endif>
                <span style="text-decoration: underline; font-weight: bold;">{{ date('m/d/Y h:i:s a') }}</span>
                <br> <span style="font-weight: normal;font-size: 14px">Date</span> </p>
            </div>
            <!--col-md-5-->
        </div>
        <!--row-->

        <div class="row" style="margin-top: 20px">
            <div class="col-print-2"></div>
            <div class="col-print-4 text-center">
                <span style="font-weight: bold;">
                    @if($score->date_acknowledge_by_manager)
                    <img src="{{ asset('storage')}}/{{ $score->themanagersignature->user_id }}/signatures/{{$score->themanagersignature->file}}" alt="">
                    <br><i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> <small>{{ date('m/d/Y h:i:s a', strtotime($score->date_acknowledge_by_manager)) }}</small>
                    @else
                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                    @endif
                </span>
                <span style="text-decoration: underline; font-weight: bold;">
                    @if(!empty($score->thenewManager))
                    <br> {{strtoupper($score->thenewManager->name)}}
                    @elseif($score->thetl->themanager)
                    <br> {{strtoupper($score->thetl->themanager->name)}}
                    @endif
                </span>
                <br> <span style="font-weight: normal;font-size: 14px">Operations Manager</span> </p>
            </div>
            <!--col-md-5-->


        </div>
        <!--row-->
        <div class="row" style="margin-top: 20px">
            <div class="col-print-1"></div>
            <div class="col-print-11 text-center">
                <span style="font-weight: bold;">
                    @if($score->date_acknowledge_by_towerhead)
                    <img src="{{ asset('storage')}}/{{ $score->thetowerheadsignature->user_id }}/signatures/{{$score->thetowerheadsignature->file}}" alt="">
                    <br><i class="mdi mdi-check-circle fa-1x" style="color: #04b381;"></i> <small>{{ date('m/d/Y h:i:s a', strtotime($score->date_acknowledge_by_towerhead)) }}</small>
                    @else
                    <i class="fa fa-warning fa-1x" style="color: #dd4b39;"></i>
                    @endif
                </span><br>
                <span style="text-decoration: underline; font-weight: bold;">
                    {{ucwords($towerhead->value)}}
                </span>
                <br> <span style="font-weight: normal;font-size: 14px">Tower Head</span> </p>
            </div>
            <!--col-md-5-->
        </div>
        <!--row-->


    </div>
    <!--container-->
</body>

</html>

<script>
    window.print();

    function goBack() {
        window.history.back();
    }

    function printThis() {
        window.print();
    }
</script>