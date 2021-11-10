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

use CommissionsCalculator\Contracts\OutputInterface;

final class Output implements OutputInterface
{
    /**
     * test mode status
     *
     * @param string $line
     * @return mixed
     */
    private bool $testMode = false;

    /**
     * write line to console
     *
     * @param string $line
     * @return mixed
     */
    public function writeLn(string $line): mixed
    {
        return $this->testMode ? $line : fwrite(STDOUT, $line, strlen($line));
    }

    /**
     * enable test mode
     *
     * @return boolean
     */
    public function enableTestMode(): bool
    {
        return $this->testMode = true;
    }

    /**
     * handle exception method
     *
     * @param callable $callback
     * @return void
     */
    public function handleException(callable $callback): void
    {
        try {
            $callback();
        } catch (\Exception $e) {
            $trace  = "\n -> ". get_class($e) . " : \n\n";
            $trace .= "    Message : " . $e->getMessage() . "\n";
            $trace .= "    File    : " . $e->getFile() . "\n";
            $trace .= "    Line    : " . $e->getLine() . "\n";
            $this->writeLn($trace);
        }
    }
}
