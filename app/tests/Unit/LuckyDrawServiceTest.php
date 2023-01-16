<?php

namespace Tests\Unit;

use App\Exceptions\Definition\ExceedDrawingException;
use App\Models\PointGain;
use App\Models\User;
use App\Services\Implements\LuckyDrawService;
use App\Services\Implements\PointDistribution;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class LuckyDrawServiceTest extends TestCase
{
    use RefreshDatabase;

    public function provide()
    {
        return [
            [
                Carbon::now('UTC')->sub('2', 'days')->timestamp,
                false,
                100,
            ],
            [
                Carbon::now('UTC')->timestamp,
                true,
                100,
            ],
        ];
    }


    /**
     * @dataProvider provide
     * @return void
     * @throws \Throwable
     */
    public function testGainPoint($timeGain, $preAssertException, $pointSet)
    {
        [$userMock, $distribute] = $this->prepareScenario($timeGain, $pointSet);
        $service = new LuckyDrawService($distribute, new PointGain());
        if ($preAssertException) {
            $this->expectException(ExceedDrawingException::class);
        }
        $pointGain = $service->gainPoint($userMock);
        $this->assertTrue($pointGain->point === $pointSet);
        $this->assertTrue($userMock->point === $pointSet);
    }


    private function prepareScenario($timeGain, $pointSet): array
    {
        $user = User::create([
            'name' => 'test',
            'phone' => '1800',
            'password' => 'ramdom',
            'timezone' => 'UTC',
        ]);

        PointGain::create([
            'user_uuid' => $user->uuid->toString(),
            'point' => $pointSet,
            'time' => $timeGain,
        ]);

        $distribution = $this->partialMock(PointDistribution::class, function (MockInterface $mock) use ($pointSet) {
            $mock->shouldReceive('getPoint')->andReturn($pointSet);
        });

        return [$user, $distribution];
    }
}
