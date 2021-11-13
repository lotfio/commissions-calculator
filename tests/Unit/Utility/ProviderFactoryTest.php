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

namespace Tests\Unit\Utility;

use CommissionsCalculator\Contracts\ProviderInterface;
use PHPUnit\Framework\TestCase;
use CommissionsCalculator\Utility\ProviderFactory; 
use CommissionsCalculator\Exceptions\ProviderFactoryException;

class ProviderFactoryTest extends TestCase
{
    public function testGetUnregisteredProvider()
    {
        $providerFactory = new ProviderFactory;
        $this->expectException(ProviderFactoryException::class);
        $providerFactory->get('cardVerification');
    }

    public function testGetRegisteredProvider()
    {
        $providerFactory = new ProviderFactory;
        $provider        = $providerFactory->get('binLookup');

        $this->assertInstanceOf(ProviderInterface::class, $provider);
    }
}