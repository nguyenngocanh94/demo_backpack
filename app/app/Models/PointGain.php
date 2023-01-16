<?php

namespace App\Models;

use App\Models\Traits\UuidAsKey;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PointGain
 *
 * @property string $uuid
 * @property string $user_uuid
 * @property int $point
 * @property string|null $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain query()
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain whereUserUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PointGain whereUuid($value)
 * @mixin \Eloquent
 */
class PointGain extends Model
{
    use CrudTrait;
    use UuidAsKey;

    protected $table = 'point_gains';

    protected $primaryKey = 'uuid';

    protected $fillable = ['user_uuid', 'point', 'time'];
}
