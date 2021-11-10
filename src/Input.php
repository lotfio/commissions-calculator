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

namespace CommissionsCalculator;

use CommissionsCalculator\Contracts\InputInterface;

final class Input implements InputInterface
{
    /**
     * input command method
     *
     * returns user input command
     *
     * @return string
     */
    public function command(): string
    {
        global $argv;
        return $argv[1] ?? '';
    }
}
