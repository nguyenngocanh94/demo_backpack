<?php

namespace Tests\Unit;

use App\Exceptions\Definition\ExceedDrawingException;
use App\Models\PointGain;
use App\Models\User;
use App\Services\Implements\LuckyDrawService;
use App\Services\Implements\PointDistribution;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Mockery\MockInterface;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class LuckyDrawServiceTest extends TestCase
{
    use RefreshDatabase;

    public function provide()
    {
        return [
            [
                Carbon::now('UTC')->timestamp,
                function(){
                    $this->expectException(ExceedDrawingException::class);
                },
                100
            ],
            [
                Carbon::now('UTC')->sub('2', 'days')->timestamp,
                function(){

                },
                100
            ]
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider provide
     * @return void
     */
    public function testGainPoint($timeGain, $preAssert, $pointSet){
        list($userMock, $distribute) = $this->prepareScenario($timeGain, $pointSet);
        $service = new LuckyDrawService($distribute, new PointGain());
        $preAssert();
        $pointGain = $service->gainPoint($userMock);
        $this->assertTrue($pointGain->point === $pointSet);
        $this->assertTrue($userMock->point === $pointSet);
    }


    private function prepareScenario($timeGain, $pointSet): array
    {
        $userUUid = \Str::uuid();
        $user = User::create([
            'uuid' => $userUUid,
            'name' => 'test',
            'phone' => '1800',
            'password' => 'ramdom'
        ]);

        $pointGain = new PointGain();
        $pointGain->point = $pointSet;
        $pointGain->user_uuid = $userUUid;
        $pointGain->time = $timeGain;

        $pointGain->save();

        $distribution = $this->partialMock(PointDistribution::class, function (MockInterface $mock)use ($pointSet) {
            $mock->shouldReceive('getPoint')->andReturn($pointSet);
        });

        return [$user, $distribution];
    }
}
