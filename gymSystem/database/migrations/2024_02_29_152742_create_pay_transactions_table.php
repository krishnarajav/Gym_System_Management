<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            create table Pay_Transactions (
                id int,
                payer_id varchar(10),
                payee_id varchar(10),
                payment_mode varchar(20),
                pay_date date,
                amount decimal(10, 2),
                transaction_id varchar(20),
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp on update current_timestamp
            )
        ');
    }

    public function down(): void
    {
        DB::statement('drop table if exists Pay_Transactions');
    }
};
