public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->integer('quantity')->default(0);
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('quantity');
    });
}