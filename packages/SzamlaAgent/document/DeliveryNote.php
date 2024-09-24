<?php

namespace packages\SzamlaAgent\Document;

use packages\SzamlaAgent\Document\Invoice\Invoice;
use packages\SzamlaAgent\Header\DeliveryNoteHeader;

/**
 * Szállítólevél segédosztály
 *
 * @package szamlaagent\document
 */
class DeliveryNote extends Invoice
{

    /**
     * Szállítólevél kiállítása
     *
     * @throws \Exception
     */
    function __construct()
    {
        parent::__construct(null);
        // Alapértelmezett fejléc adatok hozzáadása
        $this->setHeader(new DeliveryNoteHeader());
    }
}
