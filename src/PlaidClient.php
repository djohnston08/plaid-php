<?php

namespace DJohnston\Plaid;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class PlaidClient
{
    const ENV_SANDBOX = 'sandbox';
    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION = 'production';
    const ENVIRONMENTS = [
        self::ENV_DEVELOPMENT,
        self::ENV_SANDBOX,
        self::ENV_PRODUCTION,
    ];

    /**
     * @var string
     */
    private $env;

    /**
     * @var string
     */
    private $client_id;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $public_key;

    /**
     * @var string
     */
    private $api_version;

    /**
     * @var Client
     */
    private $httpClient;

    public function __construct(array $config)
    {
        $env = $config['env'];
        if (!$this->isValidEnvironment($env)) {
            throw new \RuntimeException(sprintf('Invalid Plaid environment.  Please choose from the following: [%s]', implode(', ', self::ENVIRONMENTS)), 2);
        }

        $this->env = $env;
        $baseUri = $this->getUriFromEnvironment();
        $this->httpClient = new Client(['base_uri' => $baseUri]);

        $this->client_id = $config['client_id'];
        $this->secret = $config['secret'];
        $this->public_key = $config['public_key'];
        $this->api_version = $config['api_version'];
    }

    //
    // Plaid API Endpoints
    //

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
    
    public function createProcessorToken()
    {
    }

    public function invalidateAccessToken()
    {
        //
    }

    public function updateAccessTokenVersion()
    {
        //
    }

    public function removeItem()
    {
        //
    }

    public function getItem()
    {
        //
    }

    public function updateItemWebhook()
    {
        //
    }

    public function getAccounts()
    {
        //
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

    public function createStripeToken()
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

    /**
     * @param string $env
     * @return bool
     */
    private function isValidEnvironment(string $env)
    {
        return in_array($env, self::ENVIRONMENTS);
    }

    /**
     * @return string
     */
    private function getUriFromEnvironment()
    {
        switch ($this->env) {
            case self::ENV_SANDBOX:
                return 'https://sandbox.plaid.com';

                break;
            case self::ENV_DEVELOPMENT:
                return 'https://development.plaid.com';

                break;
            case self::ENV_PRODUCTION:
                return 'https://api.plaid.com';

                break;
        }

        throw new \RuntimeException('Code should never be reached.  Get uri called from invalid environment');
    }

    private function handleClientIdRequest(string $path, array $body)
    {
        return $this->handleRequest($path, array_merge($body, [
            'client_id' => $this->client_id,
            'secret' => $this->secret
        ]));
    }

    private function handlePublicKeyRequest(string $path, array $body)
    {
        return $this->handleRequest($path, array_merge($body, [
            'public_key' => $this->public_key
        ]));
    }

    private function handleRequest(string $path, array $body)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Plaid-Version' => $this->api_version,
            'User-Agent' => 'Plaid Laravel v'.config('plaid.plaid_laravel_version'),
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
