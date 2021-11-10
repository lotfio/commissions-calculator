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

use CommissionsCalculator\Exceptions\ProviderException;
use CommissionsCalculator\Contracts\ProviderInterface;

final class Provider
{
    /**
     * registered providers array
     *
     * @var array
     */
    private array $providers = [
        'binLookup'    => \CommissionsCalculator\Providers\BinLookupProvider::class,
        'exchangeRate' => \CommissionsCalculator\Providers\ExchangeRateProvider::class
    ];


    /**
     * get provider
     *
     * @param  string $provider
     * @return ProviderInterface
     */
    public function get(string $provider): ProviderInterface
    {
        if (!array_key_exists($provider, $this->providers)) {
            throw new ProviderException("Provider $provider not registered");
        }

        return new $this->providers[$provider]();
    }
}
