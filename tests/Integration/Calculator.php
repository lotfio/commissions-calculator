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

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use CommissionsCalculator\Calculator;
use CommissionsCalculator\Input;
use CommissionsCalculator\Output;
use CommissionsCalculator\Utility\Transactions;
use CommissionsCalculator\Utility\Currency;
use CommissionsCalculator\Utility\ProviderFactory;

use CommissionsCalculator\Exceptions\TransactionsException;

class CalculatorTest extends TestCase
{
    public function testCalculatorInvalidTransactionsFile()
    {
        $calculator = new Calculator(
            new Input(['','']), new Output, new ProviderFactory, new Transactions, new Currency
        );

        $this->expectException(TransactionsException::class);
        $calculator->calculate();
    }

    public function testCalculatorValidTransactionsFile()
    {
        $output = new Output;
        $output->enableTestMode();
        $calculator = new Calculator(
            new Input(['','./tests/stubs/transactions.txt']), $output, new ProviderFactory, new Transactions, new Currency
        );

        $result = explode("\n", $calculator->calculate());

        $this->assertIsArray($result);
        $this->assertCount(6, $result); // 5 transactions with last \n white space
    }
}