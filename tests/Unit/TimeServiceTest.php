<?php

namespace Tests\Unit;

use App\Services\TimeService;
use PHPUnit\Framework\TestCase;

class TimeServiceTest extends TestCase
{
    public function test_it_calculates_hours_without_break(): void
    {
        $service = new TimeService();

        $this->assertSame(8.0, $service->calculateTimeWorked('09:00:00', '17:00:00', false));
    }

    public function test_it_deducts_thirty_minutes_for_break(): void
    {
        $service = new TimeService();

        $this->assertSame(7.5, $service->calculateTimeWorked('09:00:00', '17:00:00', true));
    }
}
