<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->longText('pagespeed_screenshot')->nullable();
            $table->unsignedTinyInteger('pagespeed_performance')->nullable();
            $table->unsignedTinyInteger('pagespeed_seo')->nullable();
            $table->unsignedTinyInteger('pagespeed_accessibility')->nullable();
            $table->unsignedTinyInteger('pagespeed_best_practices')->nullable();
        });
    }

    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'pagespeed_screenshot',
                'pagespeed_performance',
                'pagespeed_seo',
                'pagespeed_accessibility',
                'pagespeed_best_practices',
            ]);
        });
    }
};
