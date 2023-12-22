<?php

namespace App\Manager;

use Exception;
use \App\Manager\Utility\Formatter as OldInvoiceFormatter;

class Formatter
{
    /**
     * @throws Exception
     */
    public static function generateInvoiceId()
    {
       return OldInvoiceFormatter::generateInvoiceId();
    }
}
