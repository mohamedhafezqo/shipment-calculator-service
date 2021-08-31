<?php declare(strict_types=1);

namespace App\Service\ShipmentProvider;

use App\Service\ShipmentProvider\Contract\ProviderInterface;

/**
 * Class NullProvider
 *
 * @package App\Service\ShipmentProvider
 */
final class NullProvider implements ProviderInterface
{
    /**
     * @return array
     */
    public function getPriceList(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return '';
    }

    /**
     * @param string $size
     *
     * @return float
     */
    public function getPriceBySize(string $size): float
    {
        return 0.00;
    }
}
