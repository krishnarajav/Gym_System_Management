<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
            create table Sessions (
                s_id int,
                s_date date,
                s_time timestamp, 
                c_id varchar(10),
                t_id varchar(10),
                foreign key (c_id) references Customers(c_id) on delete cascade,
                foreign key (t_id) references Trainers(t_id) on delete cascade,
                primary key(s_id, s_date, c_id), 
                created_at timestamp default current_timestamp,
                updated_at timestamp default current_timestamp on update current_timestamp
            )
        ');
    }

    public function down(): void
    {
        DB::statement('drop table if exists Sessions');
    }
};