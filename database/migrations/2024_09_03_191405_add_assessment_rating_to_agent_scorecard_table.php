<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssessmentRatingToAgentScorecardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            $table->string('quality_self_assessment_rating')->nullable();
            $table->string('productivity_self_assessment_rating')->nullable();
            $table->string('reliability_self_assessment_rating')->nullable();
            $table->string('behavior_self_assessment_rating')->nullable();
            $table->string('profit_self_assessment_rating')->nullable();
            $table->string('people_self_assessment_rating')->nullable();
            $table->string('partnership_self_assessment_rating')->nullable();
            $table->string('engagement_self_assessment_rating')->nullable();
            $table->string('priority_self_assessment_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_scorecard', function (Blueprint $table) {
            $table->dropColumn('quality_self_assessment_rating');
            $table->dropColumn('productivity_self_assessment_rating');
            $table->dropColumn('reliability_self_assessment_rating');
            $table->dropColumn('behavior_self_assessment_rating');
            $table->dropColumn('profit_self_assessment_rating');
            $table->dropColumn('people_self_assessment_rating');
            $table->dropColumn('partnership_self_assessment_rating');
            $table->dropColumn('engagement_self_assessment_rating');
            $table->dropColumn('priority_self_assessment_rating');
        });
    }
}
