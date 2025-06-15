<?php

namespace App\Models;

use App\Http\Dto\ProductPurchaseDtoBuilder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $fillable = [
        'distributor_id',
        'product_id',
        'purchase_type',
        'quantity'
    ];

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function createViaProductPurchase(int $distributorId, int $productId, ProductPurchaseDtoBuilder $builder): void
    {
        Order::create([
            'distributor_id' => $distributorId,
            'product_id' => $productId,
            'purchase_type' => $builder->purchaseType->name,
            'quantity' => $builder->quantity
        ]);
    }
}
