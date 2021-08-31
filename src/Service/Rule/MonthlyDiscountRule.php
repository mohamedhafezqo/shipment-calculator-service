<?php declare(strict_types=1);

namespace App\Service\Rule;

use App\DTO\Transaction;
use App\Service\Rule\Contract\RuleInterface;

/**
 * Class MonthlyDiscountRule
 *
 * @package App\Service\Rule
 */
class MonthlyDiscountRule implements RuleInterface
{
    const MAXIMUM_MONTHLY_DISCOUNT = 10;

    private array $monthlyOccurringDiscount;

    /**
     * @param Transaction $transaction
     */
    public function apply(Transaction $transaction): void
    {
        $month = $transaction->getDate()->format('Y-m');
        $accumulatedDiscount = $this->getAccumulatedDiscountByMonth($month);
        $affordableFund = self::MAXIMUM_MONTHLY_DISCOUNT - ($accumulatedDiscount + $transaction->getDiscount());

        if ($affordableFund >= 0) {
            $this->monthlyOccurringDiscount[$month] += $transaction->getDiscount();

            return;
        }

        $availableFund = self::MAXIMUM_MONTHLY_DISCOUNT - $accumulatedDiscount;
        $shippingCost = ($transaction->getShippingCost() + $transaction->getDiscount()) - $availableFund;

        $transaction->setDiscount($availableFund);
        $transaction->setShippingCost($shippingCost);
    }

    private function getAccumulatedDiscountByMonth(string $month): float
    {
        if (!isset($this->monthlyOccurringDiscount[$month])) {
            $this->monthlyOccurringDiscount[$month] = 0.00;
        }

        return $this->monthlyOccurringDiscount[$month];
    }
}
