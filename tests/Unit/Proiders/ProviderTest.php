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
use CommissionsCalculator\Providers\Provider;
use CommissionsCalculator\Exceptions\ProviderException;

class ProviderTest extends TestCase
{
    protected $provider;

    public function setUp(): void
    {
        // another way of testing private/protected members with anonymous class
        $this->provider = new class extends Provider {
            public function pullFromUrlProtectedMethod(string $url): string
            {
                return $this->pullFromUrl($url);
            }
        };
    }

    public function testPullFromUrlMethodWrongUrl()
    {
        $this->expectException(ProviderException::class);
        $this->provider->pullFromUrlProtectedMethod('invalidUrl');
    }

    public function testPullFromUrlMethodValidUrl()
    {
        $response = $this->provider->pullFromUrlProtectedMethod(
            dirname(__DIR__, 2) . '/stubs/transactions.txt'
        );
        
        $this->assertIsString($response);
    }
}