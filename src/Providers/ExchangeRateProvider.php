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

namespace CommissionsCalculator\Providers;

use CommissionsCalculator\Contracts\ProviderInterface;

final class ExchangeRateProvider extends Provider implements ProviderInterface
{
    /**
     * api url
     *
     * @var string
     */
    private string $apiUrl = 'http://api.exchangeratesapi.io/v1';

    /**
     * api key
     *
     * @var string
     */
    private string $apiKey = '141d030a6b177b46e259320607a50dad';

    /**
     * provides method
     *
     * this method returns an array data from a 3thd party provider
     *
     * @return array
     */
    public function provides(mixed ...$parameters): array
    {
        // build url string
        //$this->url = $this->apiUrl . "/latest?access_key=" . $this->apiKey;

        $this->url = dirname(__DIR__, 2) . "/dummy/exchange_rate.json";

        // fetch from url
        $response  = json_decode($this->pullFromUrl(), true);

        // return needed data
        return $response['rates'];
    }
}
