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

use CommissionsCalculator\Exceptions\ProviderException;

class Provider
{
    /**
     * 3rd party api url
     *
     * @var string
     */
    protected string $url;

    /**
     * pull from url method
     *
     * @return string
     */
    protected function pullFromUrl(): string
    {
        $data = @file_get_contents(
            $this->url,
            false,
            stream_context_create(["http"=>["timeout"=> 10]])
        );

        if (!$data) {
            $error = error_get_last();
            throw new ProviderException("HTTP request failed. Error was: " . $error['message']);
        }

        return $data;
    }
}
