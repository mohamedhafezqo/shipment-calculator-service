<?php declare(strict_types=1);

namespace App\Service\ShipmentProvider\Contract;

/**
 * Interface ProviderInterface
 *
 * @package App\Service\ShipmentProvider\Contract
 */
interface ProviderInterface
{
    /**
     * @param string $size
     *
     * @return float
     */
    public function getPriceBySize(string $size): float;
}
