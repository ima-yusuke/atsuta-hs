<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // 既存の `parent_id` を削除
            $table->dropColumn('parent_id');
        });

        Schema::table('categories', function (Blueprint $table) {
            // `parent_id` を外部キーとして追加
            $table->foreignId('parent_id')
                ->nullable()
                ->after('order')
                ->comment('親カテゴリーID')
                ->constrained('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // `parent_id` の外部キー制約を削除
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');

            // 以前の `integer` 型の `parent_id` に戻す
            $table->integer('parent_id')->unsigned()->nullable()->comment('親カテゴリーID');
        });
    }
};
