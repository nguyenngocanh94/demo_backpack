<?php

namespace App\Models;

use App\Models\Traits\UuidAsKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Redemption
 *
 * @property string $uuid
 * @property string $user_uuid
 * @property string $coupon_uuid
 * @property int $point
 * @property string $qrcode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coupon|null $coupon
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption query()
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption whereCouponUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption whereQrcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Redemption whereUuid($value)
 * @mixin \Eloquent
 */
class Redemption extends Model
{
    use UuidAsKey;

    protected $table = 'redemptions';
    protected $primaryKey = 'uuid';
    protected $fillable = ['user_uuid', 'coupon_uuid', 'point', 'qrcode'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
