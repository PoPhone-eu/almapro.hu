<?php

namespace packages\SzamlaAgent\Item;

use packages\SzamlaAgent\Ledger\ReceiptItemLedger;
use packages\SzamlaAgent\SzamlaAgentException;
use packages\SzamlaAgent\SzamlaAgentUtil;

/**
 * Nyugtatétel
 *
 * @package SzamlaAgent\Item
 */
class ReceiptItem extends Item
{

    /**
     * Tételhez tartozó főkönyvi adatok
     *
     * @var ReceiptItemLedger
     */
    protected $ledgerData;

    /**
     * Nyugtatétel példányosítás
     *
     * @param string $name         tétel név
     * @param int    $netUnitPrice nettó egységár
     * @param double $quantity     mennyiség
     * @param string $quantityUnit mennyiségi egység
     * @param string $vat          áfatartalom
     */
    public function __construct($name, $netUnitPrice, $quantity = self::DEFAULT_QUANTITY, $quantityUnit = self::DEFAULT_QUANTITY_UNIT, $vat = self::DEFAULT_VAT)
    {
        parent::__construct($name, $netUnitPrice, $quantity, $quantityUnit, $vat);
    }

    /**
     * @return array
     * @throws SzamlaAgentException
     */
    public function buildXmlData()
    {
        $data = [];
        $this->checkFields();

        $data['megnevezes']       = $this->getName();

        if (SzamlaAgentUtil::isNotBlank($this->getId())) {
            $data['azonosito']    = $this->getId();
        }

        $data['mennyiseg']        = SzamlaAgentUtil::doubleFormat($this->getQuantity());
        $data['mennyisegiEgyseg'] = $this->getQuantityUnit();
        $data['nettoEgysegar']    = SzamlaAgentUtil::doubleFormat($this->getNetUnitPrice());
        $data['afakulcs']         = $this->getVat();
        $data['netto']            = SzamlaAgentUtil::doubleFormat($this->getNetPrice());
        $data['afa']              = SzamlaAgentUtil::doubleFormat($this->getVatAmount());
        $data['brutto']           = SzamlaAgentUtil::doubleFormat($this->getGrossAmount());

        if (SzamlaAgentUtil::isNotNull($this->getLedgerData())) {
            $data['fokonyv']      = $this->getLedgerData()->buildXmlData();
        }

        return $data;
    }

    /**
     * @return ReceiptItemLedger
     */
    public function getLedgerData()
    {
        return $this->ledgerData;
    }

    /**
     * @param ReceiptItemLedger $ledgerData
     */
    public function setLedgerData(ReceiptItemLedger $ledgerData)
    {
        $this->ledgerData = $ledgerData;
    }
}
