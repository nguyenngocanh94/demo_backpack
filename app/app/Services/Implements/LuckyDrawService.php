<?php

namespace App\Services\Implements;

use App\Exceptions\Definition\ExceedDrawingException;
use App\Models\PointGain;
use App\Models\User;
use App\Services\LuckyDrawInterface;
use App\Services\PointDistributionInterface;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

final class LuckyDrawService implements LuckyDrawInterface
{
    public function __construct(private readonly PointDistributionInterface $distribution, private readonly PointGain $pointGainModel)
    {
    }

    /**
     * @param User $user
     * @return PointGain
     * @throws ExceedDrawingException
     * @throws Throwable
     */
    public function gainPoint(User $user): PointGain
    {
        try {
            DB::beginTransaction();
            if (false === $this->canGain($user)){
                throw new ExceedDrawingException('got the limit today');
            }
            $point = $this->distribution->getPoint();
            /** @var PointGain $pointGain */
            $pointGain = $user->pointGains()->create([
                'point' => $point,
                'time' => Carbon::now('UTC')->timestamp,
                'user_uuid' => $user->uuid
            ]);
            $user->increment('point', $point);
            DB::commit();

            return $pointGain;
        }catch (Throwable $exception){
            Log::error(sprintf('exception when gain point on daily lucky drawing: %s', $exception->getMessage()));
            DB::rollBack();
            throw $exception;
        }
    }

    private function canGain(User $user): bool
    {
        $tz = $user->timezone;
        $now = Carbon::now($tz);
        $startOfDayTs = $now->startOfDay()->timestamp;
        $endOfDayTs = $now->endOfDay()->timestamp;

        $query = $this->pointGainModel->newQuery();
        $query->where('time', '>=', $startOfDayTs)->where('time','<=', $endOfDayTs)
        ->where('user_uuid', '=', $user->uuid);
        return $query->count('uuid') === 0;
    }
}
