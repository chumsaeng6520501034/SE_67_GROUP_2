<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use App\Models\Tour;
use App\Models\Booking;
use App\Models\RequestTour;
use App\Models\Offer;
use Illuminate\Console\Command;

class CheckTourDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-tour-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to change tour status or request_status and ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredTours = Tour::where('End_of_sale_date', '<', Carbon::now())
            ->where('end_tour_date', '<', Carbon::now())
            ->whereNotIn('status', ['cancal', 'collect', 'finish'])
            ->get();

        foreach ($expiredTours as $tour) {
            $tourStatus = ['status' => 'finish'];
            $tour->update($tourStatus);

            $this->info("Tour ID {$tour->id_tour} status updated to finish.");
        }
        $collectTours = Tour::where('End_of_sale_date', '<', Carbon::now())
            ->where('end_tour_date', '>', Carbon::now())
            ->whereNotIn('status', ['cancal', 'collect', 'finish'])
            ->get();
        // $request =;
        // $booking =;
        // $offer =;
    }
}
