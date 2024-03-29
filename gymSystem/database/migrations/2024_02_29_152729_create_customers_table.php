<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            create table Customers (
                id int,
                c_id varchar(10) primary key,
                p_id varchar(10),
                p_start date,
                p_end date,
                p_status varchar(10),
                foreign key (p_id) references Plans(p_id) on delete no action,
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp on update current_timestamp
            )
        ');
    }

    public function down(): void
    {
        DB::statement('drop table if exists Customers');
    }
};