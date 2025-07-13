<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni_contact_surveys', function (Blueprint $table) {
            if (!Schema::hasColumn('alumni_contact_surveys', 'survey_batch_id')) {
                $table->unsignedBigInteger('survey_batch_id')->nullable()->after('id');
                $table->foreign('survey_batch_id')
                    ->references('id')
                    ->on('contact_survey_batches')
                    ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alumni_contact_surveys', function (Blueprint $table) {
            if (Schema::hasColumn('alumni_contact_surveys', 'survey_batch_id')) {
                $table->dropForeign(['survey_batch_id']);
                $table->dropColumn('survey_batch_id');
            }
        });
    }
};
