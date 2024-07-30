<?php

use carbon\carbon;

$dt = carbon::now();
$dt1 = carbon::now();
?>
@extends('layouts.dco-app')

@section('content')
<h3><strong>Editing Scorecard of : {{strtoupper($score->thetl->name)}}</strong></h3>
<hr>

<div class="row" style="background: white; padding: 10px;">
    <div class="col-md-12">
        @include('notifications.success')
        @include('notifications.error')

        <a href="{{url('scores/tl')}}">
            <button class="btn btn-success btn-sm"><i class="fa fa-chevron-left"></i> Back to Lists</button>
        </a>
    </div>

    <div class="col-md-1"></div>
    <div class="col-md-6">
        <form method="POST" action="{{route('tl-score.update',['id' => $score->id])}}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="month">Month <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <select name="month" id="month" class="form-control">
                            <option selected value="{{$score->month}}">{{$score->month}}</option>
                            <option value="{{$dt->addMonth()->format('M Y') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                            <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                            <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                            <option value="{{$dt->subMonth()->format('M Y') }}">{{$dt1->subMonth()->format('M Y') }}</option>
                        </select>
                        @error('month')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="target">Target % <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <input type="text" required name="target" value="{{$score->target}}" class="form-control" id="target">
                    </div>
                </div>

                <div class="col-md-3">
                    <h4><strong> FINAL SCORE : <br><span style="font-size: 26px; text-align: center; font-weight: bold; margin-left: 20px;margin-top: 100px" id="totalScoreLbl">{{$score->final_score}}% </span></strong></h4>
                    <input type="hidden" value="{{$score->final_score}}" name="final_score" id="final_score">

                </div>

            </div>
            <!--row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="role">Team Leaders <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                        <select name="tl_id" required id="tl_id" class="form-control">
                            <option value="{{$score->tl_id}}">{{strtoupper($score->thetl->name)}}</option>
                            @foreach ($tls as $key => $val)
                            @if (old('tl_id') == $val->name)
                            <option value="{{ $val->id }}" selected>{{ strtoupper($val->name) }}</option>
                            @else
                            <option value="{{ $val->id }}">{{ strtoupper($val->name) }}</option>
                            @endif
                            @endforeach
                        </select>

                        @error('tl_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                </div>
            </div>
            <!--row-->
            <div class="row">

                <div class="col-md-12">
                    <table class="display nowrap table table-bordered dataTable">
                        <tr style="background: #026b4d; color: white">
                            <td colspan="2">Remarks</td>
                            <td colspan="2">Performance Ranges</td>
                            <td colspan="2">Actual Score</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="quality_actual_remarks" name="quality_actual_remarks" value="{{$score->quality_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <span style="font-weight: 500">25%</span> -  95% above Quality average<br>
                                        <span style="font-weight: 500">20%</span> -  90% to 94.99% above Quality average<br>
                                        <span style="font-weight: 500">15%</span> -  85% to 89.99% above Quality average<br>
                                        <span style="font-weight: 500">5%</span> -  8% to 84.99% above Quality average<br>
                                        <span style="font-weight: 500">0%</span>  -  79.99% below Quality average</span>
                                    </small>
                            </td>
                            <td class="ttxt-center lbl-bold">20%</td>
                            <td><input id="quality" autocomplete="off" required name="quality" value="{{$score->quality}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input style="width: 200px;" id="productivity_actual_remarks" name="productivity_actual_remarks" value="{{$score->productivity_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>90% Productivity Average</small>
                            </td>
                            <td class="ttxt-center lbl-bold">15%</td>
                            <td><input id="productivity" autocomplete="off" required name="productivity" value="{{$score->productivity}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                                <td colspan="2">
                                    <input id="reliability_actual_remarks" name="reliability_actual_remarks" value="{{$score->reliability_actual_remarks}}" type="text" class="form-control">
                                </td>

                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                    <span>
                                        <small>
                                            <span style="font-weight: 500">10.00%</span> -  95% above <br>
                                            <span style="font-weight: 500">7%</span> -  90% to 94.99% <br>
                                            <span style="font-weight: 500">5%</span> -  85% to 89.99% <br>
                                            <span style="font-weight: 500">0%</span>  -  84.99% below 
                                        </small>
                                    </span>
                                </td>
                                <td class="ttxt-center lbl-bold">10%</td>
                                <td><input id="reliability"  autocomplete="off" required name="reliability" value="{{$score->reliability}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>

                        <tr>
                            <td colspan="2">
                                <input id="no_client_escalations_actual_remarks" name="no_client_escalations_actual_remarks" value="{{$score->no_client_escalations_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>No client escalations</small>
                            </td>
                            <td class="ttxt-center lbl-bold">15%</td>
                            <td class="ttxt-center lbl-bold"><input id="no_client_escalations" autocomplete="off" required name="no_client_escalations" value="{{$score->no_client_escalations}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input id="attrtion_actual_remarks" name="attrition_actual_remarks" value="{{$score->attrition_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>Not more than 2% monthly attrition</small>
                            </td>
                            <td class="ttxt-center lbl-bold">10%</td>
                            <td class="ttxt-center lbl-bold"><input id="attrition" autocomplete="off" required name="attrition" value="{{$score->attrition}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <input id="no_pay_dispute_actual_remarks" name="no_pay_dispute_actual_remarks" value="{{$score->no_pay_dispute_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                <small>
                                    <span style="font-weight: 500">3.6</span> -  above - 5% <br>
                                    <span style="font-weight: 500">3.4</span> -  above - 3% <br>
                                    <span style="font-weight: 500">3.2%</span>  <br>
                                    <span style="font-weight: 500">Below 3.0%</span> 
                                </small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="no_pay_dispute" autocomplete="off" required name="no_pay_dispute" value="{{$score->no_pay_dispute}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="partnership_actual_remarks" name="partnership_actual_remarks" value="{{$score->partnership_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>There should be a participation from your team member.</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="partnership" autocomplete="off" required name="partnership" value="{{$score->partnership}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input id="htl_compliance_actual_remarks" name="htl_compliance_actual_remarks" value="{{$score->htl_compliance_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>HTL compliance</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="htl_compliance" autocomplete="off" required name="htl_compliance" value="{{$score->htl_compliance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="eod_reporting_actual_remarks" name="eod_reporting_actual_remarks" value="{{$score->eod_reporting_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>EOD Reporting</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="eod_reporting" autocomplete="off" required name="eod_reporting" value="{{$score->eod_reporting}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="linkedin_learning_compliance_actual_remarks" name="linkedin_learning_compliance_actual_remarks" value="{{$score->linkedin_learning_compliance_actual_remarks}}" type="text"  class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                <span><small>Linkedin Learning Compliance</small></span>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="linkedin_learning_compliance" autocomplete="off" required name="linkedin_learning_compliance" value="{{$score->linkedin_learning_compliance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input id="other_compliances_required_actual_remarks" name="other_compliances_required_actual_remarks" value="{{$score->other_compliances_required_actual_remarks}}" type="text" class="form-control">
                            </td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>Weights equally divided to the number of monthly tasks.</small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                            <td class="ttxt-center lbl-bold"><input id="other_compliances_required" autocomplete="off" required name="other_compliances_required" value="{{$score->other_compliances_required}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

<!--                         <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <95%>=90% reliability
                                    </small>
                            </td>
                            <td class="ttxt-center lbl-bold">7%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <95%>=85% reliability
                                    </small>
                            </td>
                            <td class="ttxt-center lbl-bold">5%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                    <small>
                                        <85% reliability</small> </td> <td class="ttxt-center lbl-bold">0%</td>
                        </tr> -->

                    </table>
                    <!-- <table class="display nowrap table table-bordered dataTable">
                        <tr style="background: #026B4D; color: white">
                            <td>Metrics</td>
                            <td>Actual Score</td>
                            <td>Score</td>
                        </tr>
                        <tr>
                            <td><span style="font-weight: bold; "> QUALITY (OVER-ALL) <small>20%</small></span> </td>
                            <td><input id="actual_quality" autocomplete="off" required name="actual_quality" value="{{$score->actual_quality}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="quality" autocomplete="off" required name="quality" value="{{$score->quality}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> PRODUCTIVITY <small>15%</small></span> </td>
                            <td><input id="actual_productivity" autocomplete="off" required name="actual_productivity" value="{{$score->actual_productivity}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="productivity" autocomplete="off" required name="productivity" value="{{$score->productivity}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> ADMIN & COACHING <small>30%</small> </td>
                            <td><input id="actual_admin_coaching" autocomplete="off" required name="actual_admin_coaching" value="{{$score->actual_admin_coaching}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="admin_coaching" autocomplete="off" required name="admin_coaching" value="{{$score->admin_coaching}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM PERFORMANCE <small>15%</small></span> </td>
                            <td><input id="actual_team_performance" autocomplete="off" required name="actual_team_performance" value="{{$score->actual_team_performance}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_performance" autocomplete="off" required name="team_performance" value="{{$score->team_performance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> INITIATIVE <small>5%</small></span> </td>
                            <td><input id="actual_initiative" autocomplete="off" required name="actual_initiative" value="{{$score->actual_initiative}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="initiative" autocomplete="off" required name="initiative" value="{{$score->initiative}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM ATTENDANCE <small>15%</small><br>
                                    <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span> </td>
                            <td><input id="actual_team_attendance" autocomplete="off" required name="actual_team_attendance" value="{{$score->actual_team_attendance}}" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_attendance" autocomplete="off" required name="team_attendance" value="{{$score->team_attendance}}" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>
                    </table> -->
                </div>

            </div>
            <!--row-->


            <hr>
            <button class="btn btn-info pull-right" type="submit" onclick="return confirm('Are you sure you want to add this Score?')"><i class="mdi mdi-content-save"></i> Save</button>
        </form>


    </div>
</div>



@endsection

@section('js')
<script>
    function sumTotalScore() {
        var quality = $("#quality").val();
        var productivity = $("#productivity").val();
        var partnership = $("#partnership").val();
        var no_client_escalations = $("#no_client_escalations").val();
        var no_pay_dispute = $("#no_pay_dispute").val();
        var attrition = $("#attrition").val();
        var linkedin_learning_compliance = $("#linkedin_learning_compliance").val();
        var eod_reporting = $("#eod_reporting").val();
        var htl_compliance = $("#htl_compliance").val();
        var other_compliances_required = $("#other_compliances_required").val();
        var reliability = $("#reliability").val();

        quality = isNaN(quality) ? 0 : quality;
        productivity = isNaN(productivity) ? 0 : productivity; 
        partnership = isNaN(partnership) ? 0 : partnership; 
        no_client_escalations = isNaN(no_client_escalations) ? 0 : no_client_escalations;
        no_pay_dispute = isNaN(no_pay_dispute) ? 0 : no_pay_dispute;
        attrition = isNaN(attrition) ? 0 : attrition;
        linkedin_learning_compliance = isNaN(linkedin_learning_compliance) ? 0 : linkedin_learning_compliance;
        eod_reporting = isNaN(eod_reporting) ? 0 : eod_reporting;
        htl_compliance = isNaN(htl_compliance) ? 0 : htl_compliance;
        other_compliances_required = isNaN(other_compliances_required) ? 0 : other_compliances_required;
        reliability = isNaN(reliability) ? 0 : reliability;

        var totalScore = parseFloat(quality) + parseFloat(productivity) + parseFloat(no_client_escalations) + parseFloat(no_pay_dispute) + parseFloat(attrition) + parseFloat(linkedin_learning_compliance) + parseFloat(eod_reporting) + parseFloat(htl_compliance) + parseFloat(other_compliances_required) + parseFloat(reliability) + parseFloat(partnership);
        $("#totalScoreLbl").html(parseFloat(totalScore).toFixed(2) + "%");
        $("#final_score").val(parseFloat(totalScore).toFixed(2));
    }
</script>
@endsection