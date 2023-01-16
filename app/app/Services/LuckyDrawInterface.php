<?php

namespace App\Services;

use App\Models\PointGain;
use App\Models\User;

interface LuckyDrawInterface
{
    public function gainPoint(User $user): PointGain;
}
