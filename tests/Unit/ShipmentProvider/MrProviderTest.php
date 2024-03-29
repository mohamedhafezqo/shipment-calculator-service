<?php declare(strict_types=1);

namespace App\Tests\Unit\ShipmentProvider;

use App\Service\Constant\PackageSize;
use App\Service\ShipmentProvider\MrProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class MrProviderTest
 *
 * @package App\Tests\Unit\ShipmentProvider
 */
class MrProviderTest extends WebTestCase
{
    public function testGetPriceList()
    {
        $provider = new MrProvider();

        $this->assertIsArray($provider->getPriceList());
        $this->assertIsFloat($provider->getPriceBySize(PackageSize::SMALL));
    }
}
