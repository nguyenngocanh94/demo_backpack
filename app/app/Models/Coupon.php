<?php

namespace App\Models;

use App\Models\Traits\UuidAsKey;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coupon
 *
 * @property string $uuid
 * @property array $name
 * @property array $description
 * @property int $point
 * @property int $quota
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereQuota($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUuid($value)
 * @mixin \Eloquent
 */
class Coupon extends Model
{
    use HasFactory;
    use CrudTrait;
    use UuidAsKey;
    use HasTranslations;

    protected $table = 'coupons';

    protected $primaryKey = 'uuid';

    protected $fillable = ['name', 'description','point','quota'];

    /**
     * @var array<string>
     */
    protected $translatable = ['name', 'description'];
}
