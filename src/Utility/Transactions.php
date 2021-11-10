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

namespace CommissionsCalculator\Utility;

use CommissionsCalculator\Exceptions\TransactionsException;

final class Transactions
{
    /**
     * parse transactions file
     *
     * @param string $transactionsFile
     */
    public function parseFromFile(string $transactionsFile): array
    {
        $transactionsFile = realpath($transactionsFile);

        if (!$transactionsFile || !is_file(realpath($transactionsFile))) {
            throw new TransactionsException("Transactions input file ($transactionsFile) does not seem to be a valid file");
        }

        $content = trim(file_get_contents($transactionsFile));

        return array_map(function ($line) use ($transactionsFile) {
            $data = json_decode($line);

            if (!is_object($data) || JSON_ERROR_NONE !== json_last_error()) {
                throw new TransactionsException("Unable to parse transactions file ($transactionsFile)");
            }

            return $data;
        }, explode("\n", $content));
    }
}
