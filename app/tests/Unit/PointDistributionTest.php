<?php

namespace Tests\Unit;

use App\Services\Implements\PointDistribution;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PointDistributionTest extends TestCase
{
    public function provide()
    {
        return [
            [
                '1-10,20|10-100,70|100-200,10',
                [
                    20 => array('1','10'),
                    70 => array('10','100'),
                    10 => array('100','200')
                ],
                1,200
            ],
            [
                '1-10,20|10-50,50|50-150,10',
                [
                    20 => array('1','10'),
                    50 => array('10','50'),
                    10 => array('50','150')
                ],
                1,150
            ]
        ];
    }

    /**
     * @dataProvider provide
     * @return void
     */
    public function testConstruct($envString, $sample)
    {
        $distributer = new PointDistribution($envString);
        $sampleDistribution = collect($sample)->map(function ($item, $key){
            return Collection::times($key, fn() => $item)->all();
        })->flatten(1)->all();

        $this->assertTrue($distributer->getDistributionMap() === $sampleDistribution);
    }


    /**
     * @dataProvider provide
     * @return void
     */
    public function testGetPoint($envString, $sample, $min, $max)
    {
        $distributed = new PointDistribution($envString);
        $this->assertTrue(in_array($distributed->getPoint(), range($min, $max)));
    }
}
