<?php

namespace App\Providers;

use App\Models\PointGain;
use App\Services\Implements\LuckyDrawService;
use App\Services\Implements\PointDistribution;
use App\Services\Implements\RedemptionService;
use App\Services\LuckyDrawInterface;
use App\Services\PointDistributionInterface;
use App\Services\RedemptionInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RedemptionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PointDistributionInterface::class, function () {
            return new PointDistribution(env('POINT_DISTRIBUTE_BY_BIAS')??'');
        });

        $this->app->singleton(LuckyDrawInterface::class, function () {
            $pointDistribution = $this->app->make(PointDistributionInterface::class);
            return new LuckyDrawService($pointDistribution, new PointGain());
        });

        $this->app->singleton(RedemptionInterface::class, function () {
            return new RedemptionService();
        });
    }
}
