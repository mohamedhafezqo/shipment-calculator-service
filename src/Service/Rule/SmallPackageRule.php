<?php declare(strict_types=1);

namespace App\Service\Rule;

use App\DTO\Transaction;
use App\Service\Constant\PackageSize;
use App\Service\Rule\Contract\RuleInterface;
use App\Service\ShipmentProvider\Contract\ProviderInterface;

/**
 * Class SmallPackageRule
 *
 * @package App\Service\Rule
 */
class SmallPackageRule implements RuleInterface
{
    /** @var iterable $providers */
    private iterable $providers;

    /** @var Transaction $transaction */
    private Transaction $transaction;

    /**
     * SmallPackageRule constructor.
     *
     * @param iterable $providers
     */
    public function __construct(iterable $providers)
    {
        $this->providers = $providers;
    }

    /**
     * @param Transaction $transaction
     */
    public function apply(Transaction $transaction): void
    {
        $this->transaction = $transaction;

        if (!$this->isApplicableRule()) {
            return;
        }

        $priceList = $this->getProvidersPriceList();
        $discount = $this->calculateDiscountAmount($priceList);

        $this->transaction->setShippingCost(min($priceList));
        $this->transaction->setDiscount($discount);
    }

    /**
     * @param array $priceList
     *
     * @return float
     */
    private function calculateDiscountAmount(array $priceList): float
    {
        $defaultPrice = $priceList[$this->transaction->getProviderName()];

        if (min($priceList) === $defaultPrice) {
            return 0;
        }

        return max($priceList) - min($priceList);
    }

    /**
     * @return array
     */
    private function getProvidersPriceList(): array
    {
        $prices = [];

        /** @var ProviderInterface $provider */
        foreach ($this->providers as $provider) {
            $prices[$provider->getShortName()] = $provider->getPriceBySize(
                $this->transaction->getSize()
            );
        }

        return $prices;
    }

    /**
     * @return bool
     */
    private function isApplicableRule(): bool
    {
        return PackageSize::SMALL === $this->transaction->getSize();
    }
}
