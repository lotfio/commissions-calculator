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
    private string $apiUrl = 'http://api.exchangeratesapi.io/v1/latest?access_key=';

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
     * @param  mixed ...$parameters
     * @return array
     */
    public function provides(...$parameters): array
    {
        // pull data from api
        $response  = json_decode($this->pullFromUrl(
            $this->apiUrl . $this->apiKey
        ), true);

        // return response
        return $response['rates'];
    }
}
