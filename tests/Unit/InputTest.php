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

use CommissionsCalculator\Exceptions\InputException;
use PHPUnit\Framework\TestCase;
use CommissionsCalculator\Input; 

class InputTest extends TestCase
{
    public function testInputCommandMethodMissingCommand()
    {
        $input = new Input(["file"]);
        $this->expectException(InputException::class);
        $input->command();
    }

    public function testInputCommandMethodProvidedCommand()
    {
        $input = new Input(["file", "userCommand"]);
        $this->assertSame("userCommand", 
            $input->command()
        );
    }
}