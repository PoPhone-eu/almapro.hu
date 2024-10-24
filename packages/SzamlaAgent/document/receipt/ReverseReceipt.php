<?php

namespace packages\SzamlaAgent\Document\Receipt;

use packages\SzamlaAgent\Header\ReverseReceiptHeader;

/**
 * Sztornó nyugta
 *
 * @package szamlaagent\document\receipt
 */
class ReverseReceipt extends Receipt
{

    /**
     * Sztornó nyugta létrehozása nyugtaszám alapján
     *
     * @param string $receiptNumber
     */
    public function __construct($receiptNumber = '')
    {
        parent::__construct(null);
        $this->setHeader(new ReverseReceiptHeader($receiptNumber));
    }
}
