#!/usr/bin/env php
<?php declare(strict_types=1);

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Commissions calculator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2021 Lotfio Lakehal
 */

use CommissionsCalculator\Calculator;
use CommissionsCalculator\Input;
use CommissionsCalculator\Output;
use CommissionsCalculator\Utility\Transactions;
use CommissionsCalculator\Utility\Currency;
use CommissionsCalculator\Utility\ProviderFactory;

require 'vendor/autoload.php';

$input          = new Input($argv);
$output         = new Output();
$provider       = new ProviderFactory();
$transaction    = new Transactions();
$currency       = new Currency();

$calculator     = new Calculator($input, $output, $provider, $transaction, $currency);

$output->handleException(
    fn() => $calculator->calculate()
);
