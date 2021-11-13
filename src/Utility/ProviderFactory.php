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

use CommissionsCalculator\Exceptions\ProviderFactoryException;
use CommissionsCalculator\Contracts\ProviderInterface;

final class ProviderFactory
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
     *
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     */
    public function get(string $provider): ProviderInterface
    {
        if (!array_key_exists($provider, $this->providers)) {
            throw new ProviderFactoryException("Provider $provider not registered");
        }

        // if object means already instantiated no need to re-instantiate
        if (is_object($this->providers[$provider])) {
            return $this->providers[$provider];
        }

        if (!class_exists($this->providers[$provider])) {
            throw new ProviderFactoryException("Provider $provider class not found");
        }

        return $this->providers[$provider] = new $this->providers[$provider]();
    }
}
