<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTlScorecard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tl_scorecard', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tl_id');
            $table->foreign('tl_id')->references('id')->on('users');
            $table->string('month');
            $table->string('target');

            $table->string('remarks')->nullable();
            $table->string('quality')->nullable();
            $table->string('quality_remarks')->nullable();
            $table->string('quality_self_assessment_rating')->nullable();
            $table->string('productivity')->nullable();
            $table->string('productivity_remarks')->nullable();
            $table->string('productivity_self_assessment_rating')->nullable();
            $table->string('no_client_escalations')->nullable();
            $table->string('no_client_escalations_remarks')->nullable();
            $table->string('no_client_escalations_self_assessment_rating')->nullable();
            $table->string('no_pay_dispute')->nullable();
            $table->string('no_pay_dispute_remarks')->nullable();
            $table->string('no_pay_dispute_self_assessment_rating')->nullable();
            $table->string('attrition')->nullable();
            $table->string('attrition_remarks')->nullable();
            $table->string('attrition_self_assessment_rating')->nullable();
            $table->string('linkedin_learning_compliance')->nullable();
            $table->string('linkedin_learning_compliance_remarks')->nullable();
            $table->string('linkedin_learning_compliance_self_assessment_rating')->nullable();
            $table->string('eod_reporting')->nullable();
            $table->string('eod_reporting_remarks')->nullable();
            $table->string('eod_reporting_self_assessment_rating')->nullable();
            $table->string('htl_compliance')->nullable();
            $table->string('htl_compliance_remarks')->nullable();
            $table->string('htl_compliance_self_assessment_rating')->nullable();
            $table->string('other_compliances_required')->nullable();
            $table->string('other_compliances_required_remarks')->nullable();
            $table->string('other_compliances_required_self_assessment_rating')->nullable();
            $table->string('reliability')->nullable();
            $table->string('reliability_remarks')->nullable();
            $table->string('reliability_self_assessment_rating')->nullable();

            $table->string('final_score');
            $table->string('acknowledge')->default(0);

            $table->string('acknowledge_by_tl')->default(0);
            $table->datetime('date_acknowledge_by_tl')->nullable();
            $table->integer('tl_signature_id')->nullable();

            $table->string('acknowledge_by_manager')->default(0);
            $table->datetime('date_acknowledge_by_manager')->nullable();
            $table->integer('manager_signature_id')->nullable();
            $table->unsignedBigInteger('new_manager_id')->nullable();
            $table->foreign('new_manager_id')->references('id')->on('users');

            $table->string('acknowledge_by_towerhead')->default(0);
            $table->datetime('date_acknowledge_by_towerhead')->nullable();
            $table->integer('towerhead_signature_id')->nullable();

            $table->longtext('feedback')->nullable();
            $table->longtext('action_plan')->nullable();
            $table->longtext('opportunities_strengths')->nullable();
            $table->longtext('screenshots')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tl_scorecard');
    }
}
