<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            create table Equipments (
                e_id int,
                name varchar(50),
                brand varchar(50),
                serial varchar(50),
                purchased_date date,
                price decimal(10, 2),
                primary key(e_id, serial),
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp on update current_timestamp
            )
        ');
    }

    public function down(): void
    {
        DB::statement('drop table if exists Equipments');
    }
};