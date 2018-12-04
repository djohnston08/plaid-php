<?php

namespace DJohnston\Plaid\Models;

class Transaction extends Model
{
    /**
     * @var string
     */
    private $account_id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string|null
     */
    private $iso_currency_code;

    /**
     * @var string|null
     */
    private $unofficial_currency_code;

    /**
     * @var array|null
     */
    private $category;

    /**
     * @var string|null
     */
    private $category_id;

    /**
     * @var string
     */
    private $date;

    /**
     * @var TransactionLocation
     */
    private $location;

    /**
     * @var string
     */
    private $name;

    /**
     * @var TransactionMetaData
     */
    private $payment_meta;

    /**
     * @var bool
     */
    private $pending;

    /**
     * @var string|null
     */
    private $pending_transaction_id;

    /**
     * @var string|null
     */
    private $account_owner;

    /**
     * @var string
     */
    private $transaction_id;

    /**
     * @var string
     */
    private $transaction_type;

    /**
     * @return string
     */
    public function getTransactionType(): string
    {
        return $this->transaction_type;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->account_id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getIsoCurrencyCode(): string
    {
        return $this->iso_currency_code;
    }

    /**
     * @return string|null
     */
    public function getUnofficialCurrencyCode(): string
    {
        return $this->unofficial_currency_code;
    }

    /**
     * @return array|null
     */
    public function getCategory(): array
    {
        return $this->category;
    }

    /**
     * @return string|null
     */
    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return TransactionLocation
     */
    public function getLocation(): TransactionLocation
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return TransactionMetaData
     */
    public function getPaymentMeta(): TransactionMetaData
    {
        return $this->payment_meta;
    }

    /**
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->pending;
    }

    /**
     * @return string|null
     */
    public function getPendingTransactionId(): string
    {
        return $this->pending_transaction_id;
    }

    /**
     * @return string|null
     */
    public function getAccountOwner(): string
    {
        return $this->account_owner;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transaction_id;
    }
}
