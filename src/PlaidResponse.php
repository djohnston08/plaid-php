<?php
namespace DJohnston\Plaid;

class PlaidResponse
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $body;

    public function __construct(int $statusCode, string $body)
    {
        $this->statusCode = $statusCode;
        $this->body = json_decode($body, true);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }
}
