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
    public function writeLn(string $line)
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
     * @return mixed
     */
    public function handleException(callable $callback)
    {
        try {
            $callback();
        } catch (\Exception $exception) {
            $trace  = "\n -> ". basename(str_replace('\\', DIRECTORY_SEPARATOR, get_class($exception))). " : \n\n";
            $trace .= "    Message : " . $exception->getMessage() . "\n";
            $trace .= "    File    : " . $exception->getFile() . "\n";
            $trace .= "    Line    : " . $exception->getLine() . "\n";
            return $this->writeLn($trace);
        }
    }
}
