<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DashboardViewMoreTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
//        $this->assertTrue(true);
        $this->assertStringContainsString('Star', 'Star Wars');
    }
}
