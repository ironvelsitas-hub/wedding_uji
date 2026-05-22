// database/migrations/2024_01_01_000006_modify_price_column_in_packages_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPriceColumnInPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->bigInteger('price')->change(); // Ubah ke bigInteger
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
        });
    }
}