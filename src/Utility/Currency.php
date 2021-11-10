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

final class Currency
{
    /**
     * european currencies list
     *
     * @var array
     */
    private array $eu = [
        'AT','BE','BG','CY','CZ','DE','DK','EE','ES',
        'FI','FR','GR','HR','HU','IE','IT','LT','LU',
        'LV','MT','NL','PO','PT','RO','SE','SI','SK'
    ];

    /**
     * check if currency is european
     *
     * @param  string $currencyCode
     * @return boolean
     */
    public function isEu(string $currencyCode): bool
    {
        return in_array($currencyCode, $this->eu);
    }
}
