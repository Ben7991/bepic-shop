<?php

namespace App\Http\Dto;

use App\Utils\Enum\PurchaseType;
use App\Utils\Trait\DataSanitizer;

final class ProductPurchaseDtoBuilder
{
    use DataSanitizer;

    public int $quantity;
    public PurchaseType $purchaseType;

    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function setQuantity(string $quantity): self
    {
        $this->quantity = (int)$this->sanitize($quantity);
        return $this;
    }

    public function setPurchaseType(string $purchaseType): self
    {
        if (!in_array($purchaseType, ['REORDER', 'MAINTENANCE'])) {
            throw new \Exception('Invalid purchase type');
        }

        $this->purchaseType = match ($purchaseType) {
            'REORDER' => PurchaseType::REORDER,
            'MAINTENANCE' => PurchaseType::MAINTENANCE
        };

        return $this;
    }
}
