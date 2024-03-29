<?php declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\DTO\Transaction;
use App\Service\Constant\PackageSize;
use App\Service\ProviderFactory\Contract\ProviderFactoryInterface;
use App\Service\ProviderFactory\ProviderFactory;
use App\Service\Rule\DefaultPackageRule;
use App\Service\Rule\LargeLPPackageRule;
use App\Service\Rule\MonthlyDiscountRule;
use App\Service\Rule\SmallPackageRule;
use App\Service\ShipmentCalculatorService;
use App\Service\ShipmentProvider\LpProvider;
use App\Service\ShipmentProvider\MrProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ShipmentCalculatorServiceTest
 *
 * @package App\Tests\Unit\Service
 */
class ShipmentCalculatorServiceTest extends WebTestCase
{
    public function testCalculate()
    {
        $factory = new ProviderFactory();
        $rules = $this->getRules($factory);

        $transaction = new Transaction('2015-02-07 L LP');

        $service = new ShipmentCalculatorService($rules);
        $service->calculate($transaction);

        $provider = $factory->create(LpProvider::SHORT_NAME);
        $this->assertEquals($transaction->getShippingCost(), $provider->getPriceBySize(PackageSize::LARGE));

        $transaction->setSize(PackageSize::SMALL);
        $service->calculate($transaction);

        $this->assertEquals($transaction->getShippingCost(), $provider->getPriceBySize(PackageSize::SMALL));
    }

    private function getRules(ProviderFactoryInterface $factory)
    {
        $providers = [
            new LpProvider(),
            new MrProvider(),
        ];

        return [
            new DefaultPackageRule($factory),
            new SmallPackageRule($providers),
            new LargeLPPackageRule($factory),
            new MonthlyDiscountRule(),
        ];
    }

}
