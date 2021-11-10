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
use CommissionsCalculator\Contracts\OutputInterface;
use CommissionsCalculator\Utility\Transactions;
use CommissionsCalculator\Utility\Currency;
use CommissionsCalculator\Utility\Provider;

final class Calculator
{
    /**
     * input object
     *
     * @var InputInterface
     */
    private InputInterface $input;

    /**
     * output object
     *
     * @var OutputInterface
     */
    private OutputInterface $output;

    /**
     * transactions object
     *
     * @var Transactions
     */
    private Transactions $transactions;

    /**
     * currency object
     *
     * @var Currency
     */
    private Currency $currency;

    /**
     * provider object
     *
     * @var Provider
     */
    private Provider $provider;

    /**
     * initialize dependencies
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param Provider $provider
     * @param Transactions $transactions
     * @param Currency $currency
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        Provider $provider,
        Transactions $transactions,
        Currency $currency
    ) {
        $this->input  = $input;
        $this->output = $output;
        $this->provider = $provider;
        $this->transactions = $transactions;
        $this->currency = $currency;
    }

    /**
     * calculate commissions method
     *
     * @return void
     */
    public function calculate(): void
    {
        // get transactions
        $transactions = $this->transactions->parseFromFile(
            $this->input->command()
        );

        foreach ($transactions as $transaction) {

            // get bin
            $bin    = $this->provider->get('binLookup')->provides($transaction->bin);
            $alpha2 = $bin['country']['alpha2'];
            $isEu   = $this->currency->isEu($alpha2);

            // get exchange rate
            $rate = $this->provider->get('exchangeRate')->provides();
            $rate = $rate[$transaction->currency];

            $amountFixed = 0;

            if ($transaction->currency == 'EUR' or $rate == 0) {
                $amountFixed = $transaction->amount;
            }
            if ($transaction->currency != 'EUR' or $rate > 0) {
                $amountFixed = $transaction->amount / $rate;
            }

            $commission = $amountFixed * ($isEu ? 0.01 : 0.02);
            $this->output->writeLn($commission . "\n");
        }
    }
}
