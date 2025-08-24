<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('email');
            $table->index('department_id');
        });

        // Backfill: ambil distinct nama departemen dari users.department
        $names = DB::table('users')
            ->select('department')
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->pluck('department')
            ->toArray();

        // Insert ke tabel departments
        $map = [];
        foreach ($names as $name) {
            $id = DB::table('departments')->insertGetId([
                'name' => $name,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $map[$name] = $id;
        }

        // Update users.department_id berdasar nama
        if (!empty($map)) {
            foreach ($map as $name => $id) {
                DB::table('users')
                    ->where('department', $name)
                    ->update(['department_id' => $id]);
            }
        }

        // Opsional: kalau mau, boleh dihapus kolom lama setelah yakin aman
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('department');
        // });
    }

    public function down() {
        // Jika di up() Anda drop kolom department, di down() tambahkan lagi
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('department')->nullable();
        // });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
    }
};
