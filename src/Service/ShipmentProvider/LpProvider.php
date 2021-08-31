<?php declare(strict_types=1);

namespace App\Service\ShipmentProvider;

use App\Service\ShipmentProvider\Contract\ProviderInterface;

/**
 * Class LpProvider
 *
 * @package App\Service\ShipmentProvider
 */
final class LpProvider implements ProviderInterface
{
    const SHORT_NAME  = 'LP';

    const SMALL = 'S';
    const SMALL_PRICE  = 1.50;

    const MEDIUM = 'M';
    const MEDIUM_PRICE = 4.90;

    const LARGE = 'L';
    const LARGE_PRICE = 6.90;

    public function getPriceList(): array
    {
        return [
            self::SMALL => self::SMALL_PRICE,
            self::MEDIUM => self::MEDIUM_PRICE,
            self::LARGE => self::LARGE_PRICE,
        ];
    }

    public function getShortName(): string
    {
        return self::SHORT_NAME;
    }

    public function getPriceBySize(string $size): float
    {
        $priceList = $this->getPriceList();

        return isset($priceList[$size]) ? $priceList[$size] : 0.00;
    }
}
