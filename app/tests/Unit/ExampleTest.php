<?php

namespace Tests\Unit;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $nowUtc = Carbon::now('UTC')->format('Y-m-d H:i:s');
        $nowAs = Carbon::now('Asia/Bangkok')->format('Y-m-d H:i:s');
        $this->assertTrue(true);
    }
}
