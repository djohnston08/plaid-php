<?php

namespace DJohnston\Plaid;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class PlaidClient
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var PlaidClientOptions
     */
    private $options;

    /**
     * PlaidClient constructor.
     *
     * @param PlaidClientOptions $options
     */
    public function __construct(PlaidClientOptions $options)
    {
        $this->options = $options;
        $this->httpClient = new Client(['base_uri' => $options->getBaseUri()]);
    }

    //
    // Plaid API Endpoints
    //

    /**
     * Create one-time use public token to initialize Link for update.
     *
     * @param string $accessToken
     * @return PlaidResponse
     */
    public function createPublicToken(string $accessToken)
    {
        return $this->handleClientIdRequest('/item/public_token/create', [
            'access_token' => $accessToken
        ]);
    }
    
    public function exchangePublicToken(string $publicToken)
    {
        return $this->handleClientIdRequest('/item/public_token/exchange', [
            'public_token' => $publicToken
        ]);
    }
    
    private function createProcessorToken(string $processor, string $accessToken, string $accountId)
    {
        $path = $processor === 'stripe' ? '/processor/stripe/bank_account_token/create' : sprintf('/processor/%s/processor_token/create', $processor);

        return $this->handleClientIdRequest($path, [
            'access_token' => $accessToken,
            'account_id' => $accountId
        ]);
    }

    public function createStripeToken(string $accessToken, string $accountId)
    {
        return $this->createProcessorToken('stripe', $accessToken, $accountId);
    }

    public function createApexToken(string $accessToken, string $accountId)
    {
        return $this->createProcessorToken('apex', $accessToken, $accountId);
    }

    public function createDwollaToken(string $accessToken, string $accountId)
    {
        return $this->createProcessorToken('dwolla', $accessToken, $accountId);
    }

    public function invalidateAccessToken(string $accessToken)
    {
        return $this->handleClientIdRequest('/item/access_token/invalidate', [
            'access_token' => $accessToken,
        ]);
    }

    public function updateAccessTokenVersion(string $accessToken)
    {
        return $this->handleClientIdRequest('/item/access_token/update_version', [
            'access_token_v1' => $accessToken,
        ]);
    }

    public function removeItem(string $accessToken)
    {
        return $this->handleClientIdRequest('/item/remove', [
            'access_token' => $accessToken,
        ]);
    }

    public function getItem(string $accessToken)
    {
        return $this->handleClientIdRequest('/item/get', [
            'access_token' => $accessToken,
        ]);
    }

    public function updateItemWebhook(string $accessToken, string $webhook)
    {
        return $this->handleClientIdRequest('/item/webhook/update', [
            'access_token' => $accessToken,
            'webhook' => $webhook
        ]);
    }

    public function getAccounts(string $accessToken)
    {
        return $this->handleClientIdRequest('/accounts/get', [
            'access_token' => $accessToken,
        ]);
    }

    public function getBalance()
    {
        //
    }

    public function getAuth()
    {
        //
    }

    public function getIdentity()
    {
        //
    }

    public function getIncome()
    {
        //
    }

    public function getCreditDetails()
    {
        //
    }

    public function getTransactions(string $accessToken, string $startDate, string $endDate)
    {
        return $this->handleClientIdRequest('/transactions/get', [
            'access_token' => $accessToken,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    public function getTransactionsWithOptions()
    {
        //
    }

    public function getInstitutions()
    {
        //
    }

    public function gitInstitutionById()
    {
        //
    }

    public function searchInstitutionsByName()
    {
        //
    }

    public function getCategories()
    {
        //
    }

    //
    // Sandbox only endpoints for testing
    //

    public function resetLogin()
    {
        //
    }

    public function createPublicTokenInSandbox()
    {
        //
    }

    private function handleClientIdRequest(string $path, array $body)
    {
        return $this->handleRequest($path, array_merge($body, [
            'client_id' => $this->options->getClientId(),
            'secret' => $this->options->getSecret()
        ]));
    }

    private function handlePublicKeyRequest(string $path, array $body)
    {
        return $this->handleRequest($path, array_merge($body, [
            'public_key' => $this->options->getPublicKey()
        ]));
    }

    private function handleRequest(string $path, array $body)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Plaid-Version' => $this->options->getApiVersion(),
            'User-Agent' => 'Plaid Laravel v0.1.0',
        ];

        try {
            $response = $this->httpClient->request('POST', $path, [
                'json' => $body,
                'headers' => $headers
            ]);
        } catch (TransferException $exception) {
            if (!$exception->hasResponse()) {
                throw $exception;
            }

            $response = $exception->getResponse();
        }

        return new PlaidResponse($response->getStatusCode(), (string) $response->getBody());
    }
}
