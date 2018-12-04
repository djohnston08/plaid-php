<?php

namespace DJohnston\Plaid\Models;

class TransactionMetaData extends Model
{
    /**
     * @var string|null
     */
    private $reference_number;

    /**
     * @var string|null
     */
    private $ppd_id;

    /**
     * @var string|null
     */
    private $payee_name;

    /**
     * @return string|null
     */
    public function getReferenceNumber(): string
    {
        return $this->reference_number;
    }

    /**
     * @return string|null
     */
    public function getPpdId(): string
    {
        return $this->ppd_id;
    }

    /**
     * @return string|null
     */
    public function getPayeeName(): string
    {
        return $this->payee_name;
    }
}
