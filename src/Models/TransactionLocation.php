<?php

namespace DJohnston\Plaid\Models;

class TransactionLocation extends Model
{
    /**
     * @var string|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @var string|null
     */
    private $zip;

    /**
     * @var double|null
     */
    private $lat;

    /**
     * @var double|null
     */
    private $lon;

    /**
     * @return string|null
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @return string|null
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @return float|null
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float|null
     */
    public function getLon(): float
    {
        return $this->lon;
    }
}
