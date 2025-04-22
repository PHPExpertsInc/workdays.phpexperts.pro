<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $sql = <<<SQL
        CREATE TABLE api_keys (
            apikey UUID PRIMARY KEY,
            client varchar NOT NULL,
            created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
            last_used_at TIMESTAMP WITH TIME ZONE,
            is_active BOOLEAN DEFAULT true
        );
        SQL;

        DB::unprepared($sql);
    }

    public function down()
    {
        Schema::dropIfExists('api_keys');
    }
};
