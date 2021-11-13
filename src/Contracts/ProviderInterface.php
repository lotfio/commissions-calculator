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

namespace CommissionsCalculator\Contracts;

interface ProviderInterface
{
    /**
     * provides method
     *
     * this method returns an array data from a 3thd party provider
     *
     * @param  mixed ...$parameters
     * @return array
     */
    public function provides(...$parameters): array;
}
