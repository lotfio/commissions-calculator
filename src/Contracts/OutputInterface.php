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

namespace CommissionsCalculator\Contracts;

interface OutputInterface
{
    /**
     * output write line method
     *
     * @return mixed
     */
    public function writeLn(string $line): mixed;
}
