<?php

namespace App\Console\Commands;

use App\Models\Parkir;
use Illuminate\Console\Command;

class UpdateParkingPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking:price-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $parkirBelumDibayar = Parkir::where('status', 'unpaid')->get();

        foreach ($parkirBelumDibayar as $parkir) {
            $parkir->increment('hargaPerJam', 2000);
        }
    }
}
