<?php

namespace KyleWLawrence\Bunny\Utilities;

use KyleWLawrence\Bunny\Api\Exceptions\AuthException;
use Psr\Http\Message\RequestInterface;

/**
 * Class Auth
 * This helper would manage all Authentication related operations.
 */
class Auth
{
    /**
     * The authentication setting to use a AccessKey API access_key.
     */
    const ACCESS_KEY = 'access_key';

    /**
     * @var string
     */
    protected $authStrategy;

    /**
     * @var array
     */
    protected $authOptions;

    /**
     * Returns an array containing the valid auth strategies
     *
     * @return array
     */
    protected static function getValidAuthStrategies()
    {
        return [self::ACCESS_KEY];
    }

    /**
     * Auth constructor.
     *
     * @param    $strategy
     * @param  array  $options
     *
     * @throws AuthException
     */
    public function __construct(string $strategy, array $options)
    {
        if (! in_array($strategy, self::getValidAuthStrategies())) {
            throw new AuthException('Invalid auth strategy set, please use `'
                                    .implode('` or `', self::getValidAuthStrategies())
                                    .'`');
        }

        $this->authStrategy = $strategy;

        if ($strategy == self::ACCESS_KEY) {
            if (! array_key_exists('access_key', $options)) {
                throw new AuthException('Please supply `access_key` for access_key auth.');
            }
        }

        $this->authOptions = $options;
    }

    /**
     * @param  RequestInterface  $request
     * @param  array  $requestOptions
     * @return array
     *
     * @throws AuthException
     */
    public function prepareRequest(RequestInterface $request, array $requestOptions = []): array
    {
        if ($this->authStrategy === self::ACCESS_KEY) {
            $access_key = $this->authOptions['access_key'];
            $request = $request->withAddedHeader('AccessKey', $access_key);
        } else {
            throw new AuthException('Please set authentication to send requests.');
        }

        return [$request, $requestOptions];
    }
}
