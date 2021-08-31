<?php declare(strict_types=1);

namespace App\Tests\Unit\ProviderFactory;

use App\Service\ProviderFactory\ProviderFactory;
use App\Service\ShipmentProvider\Contract\ProviderInterface;
use App\Service\ShipmentProvider\LpProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProviderFactoryTest
 *
 * @package App\Tests\Unit\ProviderFactory
 */
class ProviderFactoryTest extends WebTestCase
{
    public function testCreate()
    {
        $factory = new ProviderFactory();
        $provider = $factory->create(LpProvider::SHORT_NAME);

        $this->assertInstanceOf(ProviderInterface::class, $provider);
    }
}
