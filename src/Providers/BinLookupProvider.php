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
use CommissionsCalculator\Exceptions\ProviderException;

final class BinLookupProvider extends Provider implements ProviderInterface
{
    /**
     * api url
     *
     * @var string
     */
    private string $apiUrl = 'https://lookup.binlist.net';

    /**
     * api key
     *
     * @var string
     */
    private string $apiKey = '';

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
        if (!isset($parameters[0])) {
            throw new ProviderException(__METHOD__ . " requires a bin number to look up for");
        }

        // pull data from api
        $response = json_decode($this->pullFromUrl(
            $this->apiUrl . "/" . $parameters[0]
        ), true);

        // return response
        return $response;
    }
}
