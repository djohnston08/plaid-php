<?php
namespace DJohnston\Plaid;

class PlaidClientOptions
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
     * Latest Plaid API version
     */
    const LATEST_VERSION = '2018-05-22';

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
     * @var string
     */
    private $baseUri;

    /**
     * PlaidClientOptions constructor.
     *
     * @param string $client_id
     * @param string $secret
     * @param string $public_key
     * @param string $env
     * @param string|null $api_version
     */
    public function __construct(
        string $client_id,
        string $secret,
        string $public_key,
        string $env = 'sandbox',
        string $api_version = null
    ) {
        if (!$this->isValidEnvironment($env)) {
            throw new \RuntimeException(sprintf('Invalid Plaid environment.  Please choose from the following: [%s]', implode(', ', self::ENVIRONMENTS)), 2);
        }

        $this->client_id = $client_id;
        $this->secret = $secret;
        $this->public_key = $public_key;
        $this->env = $env;
        $this->api_version = $api_version;
        $this->baseUri = $this->getUriFromEnvironment();
    }

    /**
     * @return mixed
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->public_key;
    }

    /**
     * @return mixed
     */
    public function getApiVersion()
    {
        return $this->api_version;
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
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
}
