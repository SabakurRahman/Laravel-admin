<?php

namespace App\Manager;

use App\Models\ProductPrice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PriceCalculator
{

    final public static function calculate_discount(int|null $price, int|null $discount_fixed, int|null $discount_percent, string|null $discount_start, string|null $discount_end): array
    {
        $payable_amount          = $price;
        $discount_amount         = 0;
        $discount_fixed_amount   = 0;
        $discount_percent_amount = 0;
        if ($price !== null) {
            if (
                (!empty($discount_start) && !empty($discount_end) &&
                    Carbon::now()->between(Carbon::parse($discount_start), Carbon::parse($discount_end))) ||
                (!empty($discount_end) && Carbon::now()->lessThanOrEqualTo(Carbon::parse($discount_end))) ||
                ((empty($discount_start) && empty($discount_end)) && (!empty($discount_percent) | !empty($discount_fixed)))
            ) {
                //if today is between start and end day then discount will be applied
                // OR if end date is upcoming or today then discount will be applied
                // OR if start date and end date not specified but there has discount_fixed or percent then discount will be applied
                if (!empty($discount_percent)) {
                    $discount_percent_amount = ($price * $discount_percent) / 100;
                }
                if (!empty($discount_fixed)) {
                    $discount_fixed_amount = $discount_fixed;
                }
                $payable_amount = $price - $discount_percent_amount - $discount_fixed_amount;
            }
        }
        return [
            'payable_amount'          => $payable_amount,
            'discount_amount'         => $discount_amount,
            'discount_percent_amount' => $discount_percent_amount,
            'discount_fixed_amount'   => $discount_fixed_amount,
            'total_discount_amount'   => $discount_fixed_amount + $discount_percent_amount,
        ];
    }
    public static function priceProcessor($price)
    {

        $discount_text   = '';
        $discount_amount = 0;
        $payable_price   = 0;
        $original_price  = 0;
        if (!empty($price)) {
            if (!empty($price->variation_id)) { // grouped
                $parent_price = ProductPrice::query()->where('product_id', $price->product_id)->whereNull('variation_id')->first();
                if ($parent_price) {
                    $price->discount_fixed   = $parent_price->discount_fixed;
                    $price->discount_percent = $parent_price->discount_percent;
                    $price->discount_start   = $parent_price->discount_start;
                    $price->discount_end     = $parent_price->discount_end;
                    $price->discount_type    = $parent_price->discount_type;
                }
            }
            if (!empty($price)) {
                if ($price->discount_type === null || $price->discount_type == 2) {
                    $original_price = $price->price;
                    $payable_price  = $price->price;
                } elseif ($price->discount_type === 1) {
                    $calculated_price = self::calculate_discount(
                        $price->price,
                        $price->discount_fixed,
                        $price->discount_percent,
                        $price->discount_start,
                        $price->discount_end
                    );
                    $discount_amount  = $calculated_price['total_discount_amount'];
                    if (!empty($price->discount_percent) && !empty($price->discount_fixed)) {
                        $discount_text = $price->discount_percent . '% + ' . $price->discount_fixed . '৳ OFF';
                    } elseif (!empty($price->discount_percent)) {
                        $discount_text = $price->discount_percent . '% OFF';
                    } elseif (!empty($price->discount_fixed)) {
                        $discount_text = $price->discount_fixed . '৳ OFF';
                    }
                    $payable_price  = $calculated_price['payable_amount'];
                    $original_price = $price->price;
                } elseif ($price->discount_type === 0) {
                    $discount_text   = $price->discount_info;
                    $payable_price   = $price->price;
                    $original_price  = $price->old_price;
                    $discount_amount = $price->old_price - $price->price;
                }
            }
        }
        return [
            'discount_text'   => $discount_text,
            'discount_amount' => $discount_amount,
            'payable_price'   => $payable_price,
            'price'           => $original_price,
        ];
    }

}
