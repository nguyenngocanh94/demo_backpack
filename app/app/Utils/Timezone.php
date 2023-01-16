<?php

declare(strict_types=1);

namespace App\Utils;

class Timezone
{
    public static function verify($tz): bool
    {
        return in_array($tz, self::getTzlist());
    }

    private static function getTzlist(): array
    {
        $out = [];
        $tza = timezone_abbreviations_list();
        foreach ($tza as $zone) {
            foreach ($zone as $item) {
                $out[$item['timezone_id']] = 1;
            }
        }
        unset($out['']);
        ksort($out);
        return array_keys($out);
    }
}
