<?php declare(strict_types=1);

namespace App\Service\ProviderFactory\Contract;

use App\Service\ShipmentProvider\Contract\ProviderInterface;

/**
 * Interface ProviderFactoryInterface
 *
 * @package App\Service\ProviderFactory\Contract
 */
interface ProviderFactoryInterface
{
    /**
     * @param string $shortName
     *
     * @return ProviderInterface
     */
    public function create(string $shortName): ProviderInterface;
}
