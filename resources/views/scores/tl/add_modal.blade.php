@section('modal')
<!-- Modal -->
<div id="addTlScore" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background: #04B381 ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: white">Team Leader Scorecard</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('tl-score.store')}}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="month">Month <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="month" id="month" class="form-control">
                                    <option value="{{$dt->addMonth()->format('M Y') }}">{{$dt1->addMonth()->format('M Y') }}</option>
                                    <option value="{{$dt->subMonth()->format('M Y') }}" selected>{{$dt1->subMonth()->format('M Y') }}</option>
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
                                <input type="text" required name="target" value="{{old('target')}}" class="form-control" id="target">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h4><strong> FINAL SCORE : </strong></h4>
                            <span style="font-size: 20px; text-align: center; font-weight: bold" id="totalScoreLbl">0% </span> <input type="hidden" name="final_score" id="final_score">

                        </div>

                    </div>
                    <!--row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="role">Team Leaders <span style="color: red; font-size: 12x" title="This Field is required!">*</span></label>
                                <select name="tl_id" required id="tl_id" class="form-control">
                                    <option></option>
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
                                <td colspan="2">Assessment Rating</td>
                                <td colspan="2">Remarks</td>
                                <td colspan="2">Performance Ranges</td>
                                <td colspan="2">Actual Score</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="productivity_self_assessment_rating" name="productivity_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="productivity_actual_remarks" name="productivity_actual_remarks"  type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>100% Productivity Average</small>
                                </td>
                                <td class="ttxt-center lbl-bold">12.5%</td>
                                <td><input id="productivity" autocomplete="off" required name="productivity" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="quality_self_assessment_rating" name="quality_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="quality_actual_remarks" name="quality_actual_remarks"  type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>Straight percentage calculation</small>
                                </td>
                                <td class="ttxt-center lbl-bold">20%</td>
                                <td><input id="quality" autocomplete="off" required name="quality"  onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input id="reliability_self_assessment_rating" name="reliability_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="reliability_actual_remarks" name="reliability_actual_remarks" type="text" class="form-control">
                                </td>

                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>
                                            10.00% - 95% above <br>
                                            7% - 90% to 94.99% <br>
                                            5% - 85% to 89.99% <br>
                                            0% - 84.99% below</small>
                                </td>
                                <td class="ttxt-center lbl-bold">10%</td>
                                <td><input id="reliability"  autocomplete="off" required name="reliability" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input id="no_client_escalations_self_assessment_rating" name="no_client_escalations_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="no_client_escalations_actual_remarks" name="no_client_escalations_actual_remarks"  type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>No client escalations</small>
                                </td>
                                <td class="ttxt-center lbl-bold">15%</td>
                                <td class="ttxt-center lbl-bold"><input id="no_client_escalations" autocomplete="off" required name="no_client_escalations" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input id="attrition_self_assessment_rating" name="attrition_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="attrition_actual_remarks" name="attrition_actual_remarks"  type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>Not more than 2% monthly attrition</small>
                                </td>
                                <td class="ttxt-center lbl-bold">10%</td>
                                <td class="ttxt-center lbl-bold"><input id="attrition" autocomplete="off" required name="attrition" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <input id="no_pay_dispute_self_assessment_rating" name="no_pay_dispute_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="no_pay_dispute_actual_remarks" name="no_pay_dispute_actual_remarks"  type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>No or 1 pay dispute</small>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                                <td class="ttxt-center lbl-bold"><input id="no_pay_dispute" autocomplete="off" required name="no_pay_dispute" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="linkedin_learning_compliance_self_assessment_rating" name="linkedin_learning_compliance_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="linkedin_learning_compliance_actual_remarks" name="linkedin_learning_compliance_actual_remarks" type="text"  class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic">
                                    <span><small>Linkedin Learning Compliance</small></span>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                                <td class="ttxt-center lbl-bold"><input id="linkedin_learning_compliance" autocomplete="off" required name="linkedin_learning_compliance" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="eod_reporting_self_assessment_rating" name="eod_reporting_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="eod_reporting_actual_remarks" name="eod_reporting_actual_remarks" type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>EOD Reporting</small>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                                <td class="ttxt-center lbl-bold"><input id="eod_reporting" autocomplete="off" required name="eod_reporting" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="htl_compliance_self_assessment_rating" name="htl_compliance_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="htl_compliance_actual_remarks" name="htl_compliance_actual_remarks" type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>HTL compliance</small>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                                <td class="ttxt-center lbl-bold"><input id="htl_compliance" autocomplete="off" required name="htl_compliance" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="partnership_self_assessment_rating" name="partnership_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="partnership_actual_remarks" name="partnership_actual_remarks" type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>Partnership</small>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                                <td class="ttxt-center lbl-bold"><input id="partnership" autocomplete="off" required name="partnership" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input id="other_compliances_required_self_assessment_rating" name="other_compliances_required_self_assessment_rating"  type="text" class="form-control">
                                </td>
                                <td colspan="2">
                                    <input id="other_compliances_required_actual_remarks" name="other_compliances_required_actual_remarks" type="text" class="form-control">
                                </td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>Other Compliance Required</small>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                                <td class="ttxt-center lbl-bold"><input id="other_compliances_required" autocomplete="off" required name="other_compliances_required" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                            </tr>

                            <!-- <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>
                                        7% - 90% to 94.99%
                                        </small>
                                </td>
                                <td class="ttxt-center lbl-bold">7%</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>
                                        5% - 85% to 89.99%
                                        </small>
                                </td>
                                <td class="ttxt-center lbl-bold">5%</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: justify; padding-left: 25px; line-height: 1.5; width: 350px;  font-style: italic"><span>
                                        <small>
                                        0% - 84.99% below reliability</small> </td> <td class="ttxt-center lbl-bold">0%</td>
                            </tr> -->

                            </table>
                            <!-- <table class="display nowrap table table-bordered dataTable">
                        <tr style="background: #026b4d; color: white">
                            <td style="font-weight: 400">Metrics</td>
                            <td style="font-weight: 400">Actual Score</td>
                            <td style="font-weight: 400">Score</td>
                        </tr>
                        <tr>
                            <td><span style="font-weight: bold; "> QUALITY (OVER-ALL) <small>20%</small></span>   </td>
                            <td><input id="actual_quality" autocomplete="off" required name="actual_quality" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="quality" autocomplete="off" required name="quality" value="0" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> PRODUCTIVITY <small>15%</small></span>   </td>
                            <td><input id="actual_productivity" autocomplete="off" required name="actual_productivity" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="productivity" autocomplete="off" required name="productivity" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> ADMIN & COACHING <small>30%</small>  </td>
                            <td><input id="actual_admin_coaching" autocomplete="off" required name="actual_admin_coaching" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="admin_coaching" autocomplete="off" required name="admin_coaching" value="0" onkeyup="sumTotalScore()" type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM PERFORMANCE <small>15%</small></span>   </td>
                            <td><input id="actual_team_performance" autocomplete="off" required name="actual_team_performance" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_performance" autocomplete="off" required name="team_performance" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> INITIATIVE <small>5%</small></span>   </td>
                            <td><input id="actual_initiative" autocomplete="off" required name="actual_initiative" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="initiative" autocomplete="off" required name="initiative" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>

                        <tr>
                            <td><span style="font-weight: bold; "> TEAM ATTENDANCE <small>15%</small><br>
                                <small> (Absenteeism, Tardiness, Overbreak, Undertime)</small></span>   </td>
                            <td><input id="actual_team_attendance" autocomplete="off" required name="actual_team_attendance" value="0" type="text" class="form-control" placeholder="%"></td>
                            <td><input id="team_attendance" autocomplete="off" required name="team_attendance" value="0" onkeyup="sumTotalScore()"  type="text" class="form-control" placeholder="%"></td>
                        </tr>
                    </table> -->
                        </div>

                    </div>
                    <!--row-->

            </div>
            <!--body-->
            <div class="modal-footer">
                <button class="btn btn-info" type="submit" onclick="return confirm('Are you sure you want to add this Score?')"><i class="mdi mdi-content-save"></i> Save</button>
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>

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
