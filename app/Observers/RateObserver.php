<?php

namespace App\Observers;

use App\Models\Rate;
use App\Service\RatesService;

class RateObserver
{
    protected $rateService;

    public function __construct(RatesService $rateService)
    {
        $this->rateService = $rateService;
    }
    public function created(Rate $rate)
    {
        $this->rateService->calculateAndSaveAverageRating($rate->product_id);
    }

    /**
     * Handle the Rates "updated" event.
     *
     * @param  \App\Models\Rate  $rates
     * @return void
     */
    public function updated(Rate $rate)
    {
        $this->rateService->calculateAndSaveAverageRating($rate->product_id);
    }

    /**
     * Handle the Rates "deleted" event.
     *
     * @param  \App\Models\Rate  $rates
     * @return void
     */
    public function deleted(Rate $rate)
    {
        $this->rateService->calculateAndSaveAverageRating($rate->product_id);
    }

    /**
     * Handle the Rates "restored" event.
     *
     * @param  \App\Models\Rates  $rates
     * @return void
     */
    public function restored(Rate $rate)
    {
        //
    }

    /**
     * Handle the Rates "force deleted" event.
     *
     * @param  \App\Models\Rates  $rates
     * @return void
     */
    public function forceDeleted(Rate $rate)
    {
        //
    }
}
