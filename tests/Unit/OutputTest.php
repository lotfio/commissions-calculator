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

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use CommissionsCalculator\Output;
use Exception;

class OutputTest extends TestCase
{
    public function testWriteLineMethod()
    {
        $output = new Output;
        $output->enableTestMode();

        $this->assertSame(
            'write line to stdout',
            $output->writeLn("write line to stdout")
        );
    }

    public function testHandleExceptionMethod()
    {
        $output = new Output;
        $output->enableTestMode();

        $catch = $output->handleException(function(){ 
            throw new Exception("Test catch exception");
        });

        $this->assertStringContainsString('Message : Test catch exception', $catch);
    }
}