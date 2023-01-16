<?php

namespace App\Services;

use App\Models\PointGain;
use App\Models\User;
use Ramsey\Uuid\UuidInterface;

interface LuckyDrawInterface
{
    public function gainPoint(User $user): PointGain;

}
