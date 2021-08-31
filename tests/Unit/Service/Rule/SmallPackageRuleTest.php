<?php declare(strict_types=1);

namespace App\Tests\Unit\Service\Rule;

use App\DTO\Transaction;
use App\Service\ProviderFactory\ProviderFactory;
use App\Service\Rule\DefaultPackageRule;
use App\Service\Rule\SmallPackageRule;
use App\Service\ShipmentProvider\LpProvider;
use App\Service\ShipmentProvider\MrProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SmallPackageRuleTest
 *
 * @package App\Tests\Unit\Service\Rule
 */
class SmallPackageRuleTest extends WebTestCase
{
    public function testApply()
    {
        $transaction = new Transaction('2015-02-07 S MR');

        $mrProvider = new MrProvider();
        $lpProvider = new LpProvider();
        $providers = [
            $mrProvider,
            $lpProvider,
        ];

        $rule = new SmallPackageRule($providers);
        $rule->apply($transaction);

        $minShipmentPrice = min([
            $mrProvider->getPriceBySize('S'),
            $lpProvider->getPriceBySize('S'),
        ]);

        $this->assertEquals($transaction->getShippingCost(), $minShipmentPrice);
    }

}