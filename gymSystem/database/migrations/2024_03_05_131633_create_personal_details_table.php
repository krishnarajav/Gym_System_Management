<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // for joined_date column we use created_at column from here.

    public function up(): void
    {
        DB::statement('
            create table Personal_Details (
                c_id varchar(10),
                t_id varchar(10),
                name varchar(50),
                dob date,
                age int,
                gender varchar(10),
                height int,
                weight int,
                address varchar(50),
                mobile varchar(15),
                foreign key (c_id) references Customers(c_id) on delete cascade,
                foreign key (t_id) references Trainers(t_id) on delete cascade,
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp on update current_timestamp
            )
        ');
    }

    public function down(): void
    {
        DB::statement('drop table if exists Personal_Details');
    }
};