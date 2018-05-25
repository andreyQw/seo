<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * @package App\Model
 *
 * @property string $transaction_charge_id
 * @property string $order_id
 * @property string $type_payment
 * @property float $amount
 * @property string $currency
 *
 */
class Payment extends Model
{
    protected $fillable = [
        'transaction_charge_id', 'order_id', 'type_payment',
        'amount', 'currency'
    ];

    public function order()
    {
        return $this->belongsTo('App\Model\Order');
    }
}
