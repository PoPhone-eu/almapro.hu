<?php

namespace packages\SzamlaAgent\Item;

/**
 * Szállítólevél tétel
 *
 * @package SzamlaAgent\Item
 */
class DeliveryNoteItem extends InvoiceItem
{

    /**
     * Szállítólevél tétel létrehozása
     *
     * @param string $name          tétel név
     * @param double $netUnitPrice  nettó egységár
     * @param double $quantity      mennyiség
     * @param string $quantityUnit  mennyiségi egység
     * @param string $vat           áfatartalom
     */
    public function __construct($name, $netUnitPrice, $quantity = self::DEFAULT_QUANTITY, $quantityUnit = self::DEFAULT_QUANTITY_UNIT, $vat = self::DEFAULT_VAT)
    {
        parent::__construct($name, $netUnitPrice, $quantity, $quantityUnit, $vat);
    }
}
