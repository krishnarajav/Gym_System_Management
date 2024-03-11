<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UpdatePlanStatus extends Command
{
    protected $signature = 'update:plan-status';
    protected $description = 'Update plan status based on p_end in the Customers table';

    public function handle()
    {
        $customers = DB::select("SELECT * FROM Customers");
        if (count($customers) > 0) {
            foreach ($customers as $customer) {
                $p_end = $customer->p_end;
                $p_status = (now()->lte($p_end)) ? 'ACTIVE' : 'EXPIRED';
                $id = $customer->id;
    
                DB::update(
                    "UPDATE Customers 
                    SET p_status = ? 
                    WHERE id = ?",
                    [$p_status, $id]
                ); 
            }
            $this->info('Plan status updated successfully.');
        }
    }
}
