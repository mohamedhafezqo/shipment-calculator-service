<?php declare(strict_types=1);

namespace App\Tests\Unit\Service\Rule;

use App\DTO\Transaction;
use App\Service\Constant\PackageSize;
use App\Service\ProviderFactory\ProviderFactory;
use App\Service\Rule\DefaultPackageRule;
use App\Service\Rule\LargeLPPackageRule;
use App\Service\ShipmentProvider\LpProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class LargePackageRuleTest
 *
 * @package App\Tests\Unit\Service\Rule
 */
class LargeDiscountRuleTest extends WebTestCase
{
    public function testApply()
    {
        $factory = new ProviderFactory();
        $transaction = new Transaction('2015-02-07 L LP');

        $rule = new DefaultPackageRule($factory);
        $rule->apply($transaction);

        $rule = new LargeLPPackageRule($factory);

        for ($i = 0; $i < LargeLPPackageRule::MAXIMUM_OCCURRING; $i++) {
            $rule->apply($transaction);
        }

        $provider = $factory->create(LpProvider::SHORT_NAME);

        $this->assertEquals($transaction->getShippingCost(), 0);
        $this->assertEquals($transaction->getDiscount(), $provider->getPriceBySize(PackageSize::LARGE));
    }

}