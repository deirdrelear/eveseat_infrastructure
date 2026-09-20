<?php

namespace Deirdrelear\Seat\Infrastructure\Tests;

use Deirdrelear\Seat\Infrastructure\Service;
use PHPUnit\Framework\TestCase;

class ServiceRulesTest extends TestCase
{
    public function test_metenox_operating_constants_match_current_rules(): void
    {
        $this->assertSame(30000, Service::METENOX_BASE_DRILLING_VOLUME);
        $this->assertSame(0.40, Service::METENOX_EXTRACTION_EFFICIENCY);
        $this->assertSame(5, Service::METENOX_FUEL_BLOCKS_PER_HOUR);
        $this->assertSame(200, Service::METENOX_MAGMATIC_GAS_PER_HOUR);
    }

    public function test_moon_rate_is_not_divided_by_one_hundred_twice(): void
    {
        $this->assertSame(750.0, Service::calculateMetenoxOreUnits(0.25, 10.0, 1));
    }

    public function test_runway_uses_current_consumption(): void
    {
        $this->assertSame(
            ['fuelBlocks' => 100, 'magmaticGas' => 200],
            Service::calculateMetenoxRunwayHours(500, 40000)
        );
    }

    public function test_required_fuel_uses_current_consumption(): void
    {
        $this->assertSame(
            ['fuelBlocks' => 400, 'magmaticGas' => 10000],
            Service::calculateMetenoxRequiredFuelQuantities(100, 10000, 100)
        );
    }

    public function test_negative_duration_never_creates_negative_requirement(): void
    {
        $this->assertSame(
            ['fuelBlocks' => 0, 'magmaticGas' => 0],
            Service::calculateMetenoxRequiredFuelQuantities(100, 10000, -24)
        );
    }
}
