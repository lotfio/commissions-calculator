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
use CommissionsCalculator\Exceptions\InputException;

final class Input implements InputInterface
{
    /**
     * @var array $argv
     */
    private array $argv;

    /**
     * set up
     *
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    /**
     * input command method
     *
     * returns user input command
     *
     * @return string
     */
    public function command(): string
    {
        if (!isset($this->argv[1])) {
            throw new InputException("missing input command");
        }

        return $this->argv[1] ?? '';
    }
}
