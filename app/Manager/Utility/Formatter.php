<?php

namespace App\Manager\Utility;

use Carbon\Carbon;
use Exception;

class Formatter
{

    /**
     * @param string|null $phone
     * @return string|null
     */
    public static function addLeadingZeroToPhoneNumber(string|null $phone): string|null
    {
        if (!empty($phone)) {
            if ($phone[0] != 0 && strlen($phone) < 11) {
                $phone = '0' . $phone;
            }
        }
        return $phone;
    }

    public static function removeLeadingZeroFromPhoneNumber(string|null $phone): string|null
    {
        if (!empty($phone)) {
            $phone = substr($phone, 1, 10);
        }
        return $phone;
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function generateInvoiceId(): string
    {
        return 'ABS-' . Carbon::now()->format('ymdHis') . random_int(0, 9);
    }

    public static function generate_payment_url(string $invoice_no): string
    {
        return env('FRONT_END_APP_URL') . '/payment/' . $invoice_no;
    }

    public static function trim_sku(string|null $sku): string|null
    {
        if (!empty($sku)) {
            $sku = preg_replace('/[^a-zA-Z0-9]/', '', $sku);
        }
        return $sku;
    }
}
