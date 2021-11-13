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
use CommissionsCalculator\Providers\ExchangeRateProvider;
use CommissionsCalculator\Exceptions\ProviderException;

class ExchangeRateProviderTest extends TestCase
{
    protected $exchangeRateProvider;
    protected $exchangeRateReflectionObject;

    public function setUp(): void
    {
        $this->exchangeRateProvider         = new ExchangeRateProvider();
        $this->exchangeRateReflectionObject = new \ReflectionObject($this->exchangeRateProvider);
    }

    public function testProvidesMethodWrongUrl()
    {
        $refProperty = $this->exchangeRateReflectionObject->getProperty( 'apiUrl' );
        $refProperty->setAccessible(true);
        $refProperty->setValue( $this->exchangeRateProvider , '');

        $this->expectException(ProviderException::class);
        $this->exchangeRateProvider->provides();
    }

    public function testProvidesMethodValidUrl()
    {
        $refProperty = $this->exchangeRateReflectionObject->getProperty( 'apiUrl' );
        $refProperty->setAccessible(true);
        $refProperty->setValue( $this->exchangeRateProvider , dirname(__DIR__, 2) . "/stubs/exchange_rates.txt");

        $refProperty = $this->exchangeRateReflectionObject->getProperty( 'apiKey' );
        $refProperty->setAccessible(true);
        $refProperty->setValue( $this->exchangeRateProvider , "");

        $data = $this->exchangeRateProvider->provides();

        $this->assertIsArray($data);
        $this->assertArrayHasKey("AED", $data);
    }
}