<?php declare(strict_types=1);

namespace App\Service\ShipmentProvider;

use App\Service\ShipmentProvider\Contract\ProviderInterface;

/**
 * Class MrProvider
 *
 * @package App\Service\ShipmentProvider
 */
final class MrProvider implements ProviderInterface
{
    const SHORT_NAME  = 'MR';

    const SMALL  = 'S';
    const SMALL_PRICE  = 2.00;

    const MEDIUM = 'M';
    const MEDIUM_PRICE = 3.00;

    const LARGE  = 'L';
    const LARGE_PRICE  = 4.00;

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

        return isset($priceList[$size]) ? $priceList[$size] : 0.0;
    }
}
