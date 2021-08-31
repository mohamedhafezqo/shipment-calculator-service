<?php declare(strict_types=1);

namespace App\Service\ProviderFactory;

use App\Service\ProviderFactory\Contract\ProviderFactoryInterface;
use App\Service\ShipmentProvider\Contract\ProviderInterface;
use App\Service\ShipmentProvider\LpProvider;
use App\Service\ShipmentProvider\MrProvider;
use App\Service\ShipmentProvider\NullProvider;

/**
 * Class ProviderFactory
 *
 * @package App\Service\ProviderFactory
 */
class ProviderFactory implements ProviderFactoryInterface
{
    private array $providers = [
        LpProvider::SHORT_NAME => \APP\Service\ShipmentProvider\LpProvider::class,
        MrProvider::SHORT_NAME => \APP\Service\ShipmentProvider\MrProvider::class,
    ];

    /**
     * @param string $shortName
     *
     * @return ProviderInterface
     */
    public function create(string $shortName): ProviderInterface
    {
        foreach ($this->providers as $key => $provider) {
            if ($key === $shortName) {
                return new $provider();
            }
        }

        return new NullProvider();
    }
}
