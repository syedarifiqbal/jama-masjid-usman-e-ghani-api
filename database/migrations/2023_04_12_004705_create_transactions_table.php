<?php

use App\Models\Category;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->decimal('amount');
            $table->tinyText('description');
            $table->timestamp('approved_at')->nullable();
            $table->foreignIdFor(User::class, 'approved_by')->nullable();
            $table->foreignIdFor(Category::class, 'category_id');
            $table->foreignIdFor(TransactionType::class, 'transaction_type_id');
            $table->foreignIdFor(User::class, 'user_id');
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
        Schema::dropIfExists('transactions');
    }
}
