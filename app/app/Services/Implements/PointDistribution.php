<?php

namespace App\Services\Implements;

use App\Services\PointDistributionInterface;
use Illuminate\Support\Collection;

class PointDistribution implements PointDistributionInterface
{
    /**
     * @var array<array<int, int>>
     */
    private array $distributionMap = [];

    public function __construct(string $distributionMap)
    {
        if ($distributionMap !== '') {
            $distributionMap = collect(explode('|', $distributionMap))->map(function ($item) {
                list($rangeStr, $percent) = explode(',', $item);
                $range = explode('-', $rangeStr);
                return [$range, $percent];
            });
            $this->distributionMap = collect($distributionMap)->map(function ($item) {
                list($range, $percent) = $item;
                return Collection::times((int)$percent, fn() => $range)->all();
            })->flatten(1)->all();
        }
    }

    public function getPoint(): int
    {
        if (empty($this->distributionMap)){
            return rand(1, 100);
        }
        shuffle($this->distributionMap);
        list($min, $max) = $this->distributionMap[0];

        return rand((int)$min, (int)$max);
    }


    /**
     * @return array
     */
    public function getDistributionMap(): array
    {
        return $this->distributionMap;
    }
}
