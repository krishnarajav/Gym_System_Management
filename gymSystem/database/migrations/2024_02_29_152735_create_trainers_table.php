<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            create table Trainers (
                id int,
                t_id varchar(10) primary key,
                name varchar(50),
                dob date,
                age int,
                gender varchar(10),
                experience int,
                address varchar(50), 
                mobile varchar(15),
                salary decimal(10, 2),
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp on update current_timestamp
            )
        ');
    }

    public function down(): void
    {
        DB::statement('drop table if exists Trainers');
    }
};
