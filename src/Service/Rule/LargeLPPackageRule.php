<?php declare(strict_types=1);

namespace App\Service\Rule;

use App\DTO\Transaction;
use App\Service\Constant\PackageSize;
use App\Service\ProviderFactory\Contract\ProviderFactoryInterface;
use App\Service\Rule\Contract\RuleInterface;
use App\Service\ShipmentProvider\LpProvider;

/**
 * Class LargePackageRule
 *
 * @package App\Service\Rule
 */
class LargeLPPackageRule implements RuleInterface
{
    const MAXIMUM_OCCURRING = 3;

    private ProviderFactoryInterface $providerFactory;

    private array $monthlyRecurring;

    /**
     * LargeLPPackageRule constructor.
     *
     * @param ProviderFactoryInterface $providerFactory
     */
    public function __construct(ProviderFactoryInterface $providerFactory)
    {
        $this->providerFactory = $providerFactory;
        $this->monthlyRecurring = [];
    }

    /**
     * @param Transaction $transaction
     */
    public function apply(Transaction $transaction): void
    {
        if (!$this->isApplicableRule($transaction)) {
            return;
        }

        $month = $transaction->getDate()->format('Y-m');
        isset($this->monthlyRecurring[$month])
            ? $this->monthlyRecurring[$month]++
            : $this->monthlyRecurring[$month] = 1
        ;

        $provider = $this->providerFactory->create($transaction->getProviderName());
        $shippingCost = $provider->getPriceBySize($transaction->getSize());

        if ($this->monthlyRecurring[$month] === self::MAXIMUM_OCCURRING) {
            $transaction->setShippingCost(0);
            $transaction->setDiscount($shippingCost);
        }
    }

    /**
     * @param Transaction $transaction
     *
     * @return bool
     */
    private function isApplicableRule(Transaction $transaction): bool
    {
        return PackageSize::LARGE === $transaction->getSize()
            && LpProvider::SHORT_NAME === $transaction->getProviderName()
        ;
    }
}
