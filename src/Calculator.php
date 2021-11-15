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
use CommissionsCalculator\Utility\ProviderFactory;

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
     * ProviderFactory object
     *
     * @var ProviderFactory
     */
    private ProviderFactory $providerFactory;

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
     * initialize dependencies
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param ProviderFactory $provider
     * @param Transactions $transactions
     * @param Currency $currency
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        ProviderFactory $providerFactory,
        Transactions $transactions,
        Currency $currency
    ) {
        $this->input  = $input;
        $this->output = $output;
        $this->providerFactory = $providerFactory;
        $this->transactions = $transactions;
        $this->currency = $currency;
    }

    /**
     * calculate commissions method
     *
     * @return mixed
     */
    public function calculate()
    {
        // get transactions
        $transactions = $this->transactions->parseFile(
            $this->input->command()
        );

        $out = ''; // if testing

        foreach ($transactions as $transaction) {

            // get bin
            $bin    = $this->providerFactory->get('binLookup')->provides($transaction->bin);
            $alpha2 = $bin['country']['alpha2'];
            $isEu   = $this->currency->isEu($alpha2);

            // get exchange rate
            $rate = $this->providerFactory->get('exchangeRate')->provides();
            $rate = $rate[$transaction->currency];

            $amountFixed = 0;

            if ($transaction->currency == 'EUR' or $rate == 0) {
                $amountFixed = $transaction->amount;
            }
            if ($transaction->currency != 'EUR' or $rate > 0) {
                $amountFixed = $transaction->amount / $rate;
            }

            $commission = $amountFixed * ($isEu ? 0.01 : 0.02);
            $out .= $this->output->writeLn(sprintf("%0.2f", (ceil( $commission * 100) / 100) ) . "\n");
        }

        return $out;
    }
}
