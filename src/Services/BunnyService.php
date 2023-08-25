<?php

namespace KyleWLawrence\Bunny\Services;

use BadMethodCallException;
use Config;
use InvalidArgumentException;
use KyleWLawrence\Bunny\Http\HttpClient;

class BunnyService
{
    /**
     * Get auth parameters from config, fail if any are missing.
     * Instantiate API client and set auth AccessKey access_key.
     *
     * @throws Exception
     */
    public function __construct(
        private string $access_key = '',
        public HttpClient $client = new HttpClient,
    ) {
        $this->access_key = ($this->access_key) ? $this->access_key : config('bunny-laravel.access_key');

        if (! $this->access_key) {
            throw new InvalidArgumentException('Please set BUNNY_access_key environment variables.');
        }

        $this->client->setAuth('access_key', ['access_key' => $this->access_key]);
    }

    /**
     * Pass any method calls onto $this->client
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (is_callable([$this->client, $method])) {
            return call_user_func_array([$this->client, $method], $args);
        } else {
            throw new BadMethodCallException("Method $method does not exist");
        }
    }

    /**
     * Pass any property calls onto $this->client
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this->client, $property)) {
            return $this->client->{$property};
        } else {
            throw new BadMethodCallException("Property $property does not exist");
        }
    }
}
