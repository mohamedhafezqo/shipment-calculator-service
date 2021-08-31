<?php declare(strict_types=1);

namespace App\Tests\Unit\Service\Rule;

use App\DTO\Transaction;
use App\Service\ProviderFactory\ProviderFactory;
use App\Service\Rule\DefaultPackageRule;
use App\Service\ShipmentProvider\MrProvider;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultPackageRuleTest
 *
 * @package App\Tests\Unit\Service\Rule
 */
class DefaultPackageRuleTest extends WebTestCase
{
    public function testApply()
    {
        $transaction = new Transaction('2015-02-07 L MR');
        $factory = new ProviderFactory();

        $rule = new DefaultPackageRule($factory);
        $rule->apply($transaction);

        $MrProvider = $factory->create(MrProvider::SHORT_NAME);

        $this->assertEquals($transaction->getShippingCost(), $MrProvider->getPriceBySize('L'));
    }

}