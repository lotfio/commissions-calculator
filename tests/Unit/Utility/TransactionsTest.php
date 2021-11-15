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
use CommissionsCalculator\Utility\Transactions;
use CommissionsCalculator\Exceptions\TransactionsException;

class TransactionsTest extends TestCase
{
    protected $loadFileMethod;

    public function setUp(): void
    {
        // example of testing private/protected members with reflection api
        // opinions differ about testing private/protected members
        $class = new \ReflectionClass(Transactions::class);
        $this->loadFileMethod = $class->getMethod('loadFile');
        $this->loadFileMethod->setAccessible(true);
    }

    public function testLoadFileMethodInvalidFile()
    {
        $transactions = new Transactions;
        $this->expectException(TransactionsException::class);
        $this->loadFileMethod->invokeArgs($transactions, ['wrongFile']);
    }

    public function testLoadFileMethodValidFile()
    {
        $transactions = new Transactions;
        $fileContent  = $this->loadFileMethod->invokeArgs($transactions, [
            dirname(__DIR__, 2) . '/stubs/transactions.txt'
        ]);

        $this->assertIsString($fileContent);
        $this->assertStringContainsString('bin', $fileContent);
    }

    public function testParseFileMethodValidFileData()
    {
        $transactions = new Transactions;
        $data = $transactions->parseFile(
            dirname(__DIR__, 2) . '/stubs/transactions.txt'
        );

        $this->assertIsArray($data);
        $this->assertGreaterThan(1, count($data));
    }

    public function testParseFileMethodInValidFileData()
    {
        $transactions = new Transactions;
        $this->expectException(TransactionsException::class);
        $transactions->parseFile(
            dirname(__DIR__, 2) . '/stubs/exchange_rates.txt'
        );
    }
}