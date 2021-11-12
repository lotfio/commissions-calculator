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

use PHPUnit\Framework\TestCase;
use CommissionsCalculator\Utility\Currency; 

class CurrencyTest extends TestCase
{
    public function testIsEuMethod()
    {
        $currency = new Currency;

        $this->assertTrue(
            $currency->isEu('AT')
        );
        $this->assertFalse(
            $currency->isEu('DA')
        );
    }
}