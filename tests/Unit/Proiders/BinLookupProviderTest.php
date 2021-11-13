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
    protected $binLookupProvider;
    protected $binReflectionObject;

    public function setUp(): void
    {
        $this->binLookupProvider  = new BinLookupProvider();
        $this->binReflectionObject = new \ReflectionObject( $this->binLookupProvider );
    }

    public function testProvidesMethodMissingBin()
    {
        $refProperty = $this->binReflectionObject->getProperty( 'apiUrl' );
        $refProperty->setAccessible(true);
        $refProperty->setValue( $this->binLookupProvider , dirname(__DIR__, 2) . "/stubs");

        $this->expectException(ProviderException::class);
        $this->binLookupProvider->provides();
    }

    public function testProvidesMethodInvalidUrl()
    {
        $refProperty = $this->binReflectionObject->getProperty( 'apiUrl' );
        $refProperty->setAccessible(true);
        $refProperty->setValue( $this->binLookupProvider , dirname(__DIR__, 2) . "/stubs/bin");

        $this->expectException(ProviderException::class);
        $this->binLookupProvider->provides(45417360);
    }

    public function testProvidesMethodValidBinAndUrl()
    {
        $refProperty = $this->binReflectionObject->getProperty( 'apiUrl' );
        $refProperty->setAccessible(true);
        $refProperty->setValue( $this->binLookupProvider , dirname(__DIR__, 2) . "/stubs");
        $data = $this->binLookupProvider->provides(45417360);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('bank', $data);
    }
}