<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('title')->nullable()->after('role');
            $table->text('bio')->nullable()->after('title');
            $table->string('photo')->nullable()->after('bio');
            $table->string('credentials')->nullable()->after('photo');
            $table->string('linkedin_url')->nullable()->after('credentials');
            $table->boolean('is_team_member')->default(false)->after('linkedin_url');
            $table->enum('team_rank', ['director', 'associate'])->nullable()->after('is_team_member');
            $table->unsignedTinyInteger('team_order')->default(0)->after('team_rank');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'phone', 'title', 'bio', 'photo', 'credentials',
                'linkedin_url', 'is_team_member', 'team_rank', 'team_order',
            ]);
        });
    }
};
