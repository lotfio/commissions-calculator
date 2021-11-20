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
use PHPUnit\Framework\MockObject\MockObject;
use CommissionsCalculator\Calculator;
use CommissionsCalculator\Input;
use CommissionsCalculator\Output;
use CommissionsCalculator\Utility\Transactions;
use CommissionsCalculator\Utility\Currency;
use CommissionsCalculator\Utility\ProviderFactory;
use CommissionsCalculator\Exceptions\TransactionsException;
use CommissionsCalculator\Providers\BinLookupProvider;
use CommissionsCalculator\Providers\ExchangeRateProvider;
use DG\BypassFinals;

class CalculatorTest extends TestCase
{
    public function setUp(): void
    {
        BypassFinals::enable();
    }

    private function getTransactionsMock(): MockObject
    {
        // mocking transactions object
        $transactions = $this->getMockBuilder(Transactions::class)->getMock();
        $transactions->method('parseFile')
                    ->willReturn([  // transactions
                        (object) [
                            "bin"       => "45417360",
                            "amount"    => "100.00",
                            "currency"  => "AED"
                        ],
                        (object) [
                            "bin"       => "45417360",
                            "amount"    => "100.00",
                            "currency"  => "ALL"
                        ]
                    ]);
        return $transactions;
    }

    private function getProviderFactoryMock(): ProviderFactory
    {
        // mocking providerFactory object
        $binProvider = $this->getMockBuilder(BinLookupProvider::class)->getMock();
        $binProvider->method('provides')
                    ->willReturn([ // card information
                        "country" => [
                            "alpha2" => "JP"
                        ]
                    ]);

        $rateProvider = $this->getMockBuilder(ExchangeRateProvider::class)->getMock();
        $rateProvider->method('provides')
                    ->willReturn([ // exchange rates
                          "AED" => '4.258097',
                          "AFN" => '105.900773',
                          "ALL" => '122.826026',
                    ]);

        // register mocked providers
        $providerFactory    = new ProviderFactory;
        $reflection         = new \ReflectionObject($providerFactory);
        $property           = $reflection->getProperty('providers');
        $property->setAccessible(true);
        $property->setValue($providerFactory, [
                "binLookup"     => $binProvider,
                "exchangeRate"  => $rateProvider
            ]);

        return $providerFactory;
    }

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
        // output object
        $output = new Output;
        $output->enableTestMode();

        $calculator = new Calculator(
            new Input(['','']), $output, $this->getProviderFactoryMock(), $this->getTransactionsMock(), new Currency
        );

        $result = explode("\n", $calculator->calculate());

        $this->assertIsArray($result);
        $this->assertCount(3, $result); // 2 transactions and last \n white space
    }
}