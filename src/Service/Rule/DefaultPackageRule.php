<?php

declare(strict_types=1);

namespace App\Service\Rule;

use App\DTO\Transaction;
use App\Service\ProviderFactory\Contract\ProviderFactoryInterface;
use App\Service\Rule\Contract\RuleInterface;

/**
 * Class DefaultPackageRule
 *
 * @package App\Service\Rule
 */
class DefaultPackageRule implements RuleInterface
{
    private ProviderFactoryInterface $providerFactory;

    /**
     * DefaultPackageRule constructor.
     *
     * @param ProviderFactoryInterface $providerFactory
     */
    public function __construct(ProviderFactoryInterface $providerFactory)
    {
        $this->providerFactory = $providerFactory;
    }

    /**
     * @param Transaction $transaction
     */
    public function apply(Transaction $transaction): void
    {
        $provider = $this->providerFactory->create($transaction->getProviderName());

        $shippingCost = $provider->getPriceBySize($transaction->getSize());
        $transaction->setShippingCost($shippingCost);
    }
}
