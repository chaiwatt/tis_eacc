<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Certificate\CbScopeIsicCategoryTransaction;

class CreateCbScopeIsicCategoryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cb_scope_isic_category_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cb_scope_isic_transaction_id');
            $table->unsignedInteger('category_id');
            $table->boolean('is_checked')->default(false); 
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
        Schema::dropIfExists('cb_scope_isic_category_transactions');
    }
}
