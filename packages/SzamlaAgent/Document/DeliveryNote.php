<?php

namespace Packages\SzamlaAgent\Document;

use Packages\SzamlaAgent\Document\Invoice\Invoice;
use Packages\SzamlaAgent\Header\DeliveryNoteHeader;

/**
 * Szállítólevél segédosztály
 *
 * @package szamlaagent\document
 */
class DeliveryNote extends Invoice {

    /**
     * Szállítólevél kiállítása
     *
     * @throws \Exception
     */
    function __construct() {
        parent::__construct(null);
        // Alapértelmezett fejléc adatok hozzáadása
        $this->setHeader(new DeliveryNoteHeader());
    }
 }