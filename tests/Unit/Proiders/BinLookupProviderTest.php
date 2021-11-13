<?php

declare(strict_types=1);

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Commissions calculator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2021 Lotfio Lakehal
 */

namespace Tests\Unit\Providers;

use PHPUnit\Framework\TestCase;
use CommissionsCalculator\Providers\BinLookupProvider;
use CommissionsCalculator\Exceptions\ProviderException;

class BinLookupProviderTest extends TestCase
{
    public function testProvidesMethodMissingBin()
    {
        $bin = new BinLookupProvider;
        $this->expectException(ProviderException::class);
        $bin->provides();
    }

    public function testProvidesMethodNotFoundBin()
    {
        $bin = new BinLookupProvider;
        $this->expectException(ProviderException::class);
        $bin->provides(120);
    }

    public function testProvidesMethodValidBin()
    {
        $bin      = new BinLookupProvider;
        $response = $bin->provides(45417360);
        $this->assertIsArray($response);
    }
}