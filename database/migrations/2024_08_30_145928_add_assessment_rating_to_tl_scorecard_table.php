<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssessmentRatingToTlScorecardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tl_scorecard', function (Blueprint $table) {
            $table->string('quality_self_assessment_rating')->nullable();
            $table->string('productivity_self_assessment_rating')->nullable();
            $table->string('no_client_escalations_self_assessment_rating')->nullable();
            $table->string('no_pay_dispute_self_assessment_rating')->nullable();
            $table->string('attrition_self_assessment_rating')->nullable();
            $table->string('linkedin_learning_compliance_self_assessment_rating')->nullable();
            $table->string('eod_reporting_self_assessment_rating')->nullable();
            $table->string('htl_compliance_self_assessment_rating')->nullable();
            $table->string('other_compliances_required_self_assessment_rating')->nullable();
            $table->string('reliability_self_assessment_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tl_scorecard', function (Blueprint $table) {
            $table->dropColumn('quality_self_assessment_rating');
            $table->dropColumn('productivity_self_assessment_rating');
            $table->dropColumn('no_client_escalations_self_assessment_rating');
            $table->dropColumn('no_pay_dispute_self_assessment_rating');
            $table->dropColumn('attrition_self_assessment_rating');
            $table->dropColumn('linkedin_learning_compliance_self_assessment_rating');
            $table->dropColumn('eod_reporting_self_assessment_rating');
            $table->dropColumn('htl_compliance_self_assessment_rating');
            $table->dropColumn('other_compliances_required_self_assessment_rating');
            $table->dropColumn('reliability_self_assessment_rating');
        });
    }
}
