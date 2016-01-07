<?php


namespace MJErwin\SendOwl;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use MJErwin\SendOwl\Exception\EntityNotFoundException;
use MJErwin\SendOwl\Exception\EntityInvalidException;


/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class SendOwl
{
    protected static $instance;
    protected $api_key;
    protected $api_secret;

    /**
     * SendOwl constructor.
     */
    private function __construct()
    {
        // Private __construct to prevent instantiation via `new SendOwl`
    }

    /**
     * @return SendOwl
     */
    public static function instance()
    {
        // Singleton Pattern
        if (!self::$instance instanceof SendOwl)
        {
            self::$instance = new SendOwl();
        }

        return self::$instance;
    }

    public static function tearDown()
    {
        self::$instance = null;
    }

    /**
     * @param $api_key
     * @param $api_secret
     *
     * @return $this
     */
    public function authenticate($api_key, $api_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;

        return $this;
    }

    public function hasAuthenticationData()
    {
        return $this->api_key && $this->api_secret ? true : false;
    }

    /**
     * @param array $request_data
     * @param string $signature
     *
     * @return bool
     */
    public function isSignatureValid($request_data, $signature)
    {
        if(!$request_data)
        {
            return false;
        }

        // Decode all the values
        array_map('urldecode', $request_data);

        // Remove *signature* from the data
        unset($request_data['signature']);

        // Sort alphabetically
        ksort($request_data);

        $request_data['secret'] = $this->api_secret;

        $query = urldecode(http_build_query($request_data));

        $key = sprintf('%s&%s', $this->api_key, $this->api_secret);

        $request_signature = base64_encode(hash_hmac('sha1', $query, $key, true));

        return $request_signature == $signature ? true : false;
    }

    /**
     * @param $entity_type
     *
     * @return mixed
     */
    public function fetchEntitiesData($entity_type)
    {
        $endpoint = sprintf('%s.json', $entity_type::$api_endpoint);

        $response = $this->performRequest($endpoint);

        $response_data = $this->getResponseData($response);

        return $response_data;
    }

    /**
     * @param $entity_type
     * @param $id
     *
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function fetchEntityData($entity_type, $id)
    {
        $endpoint = sprintf('%s/%s.json', $entity_type::$api_endpoint, $id);

        try
        {
            $response = $this->performRequest($endpoint);
        } catch(ClientException $e)
        {
            if ($e->getCode() == 404)
            {
                throw new EntityNotFoundException($entity_type, $id);
            }
        }

        $response_data = $this->getResponseData($response);

        return $response_data;
    }

    /**
     * @param $entity_type
     * @param $id
     * @param $data
     *
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function updateEntity($entity_type, $id, $data)
    {
        $endpoint = sprintf('%s/%s.json', $entity_type::$api_endpoint, $id);

        try
        {
            $response = $this->performRequest($endpoint, $data, 'PUT');
        } catch(ClientException $e)
        {
            if ($e->getCode() == 404)
            {
                throw new EntityNotFoundException($entity_type, $id);
            }
        }

        $response_data = $this->getResponseData($response);

        return $response_data;
    }

    public function createEntity($entity_type, $data)
    {
        $endpoint = sprintf('%s.json', $entity_type::$api_endpoint);

        try
        {
            $response = $this->performRequest($endpoint, $data, 'POST');
        } catch(ClientException $e)
        {
            if ($e->getCode() == 422)
            {
                $errors = $this->getResponseData($e->getResponse());
                throw new EntityInvalidException($entity_type, $errors);
            }
        }

        $response_data = $this->getResponseData($response);

        return $response_data;
    }

    /**
     * @param $entity_type
     * @param $id
     *
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function deleteEntity($entity_type, $id)
    {
        $endpoint = sprintf('%s/%s.json', $entity_type::$api_endpoint, $id);

        try
        {
            $response = $this->performRequest($endpoint, [], 'DELETE');
        } catch(ClientException $e)
        {
            if ($e->getCode() == 404)
            {
                throw new EntityNotFoundException($entity_type, $id);
            }
        }

        $response_data = $this->getResponseData($response);

        return $response_data;
    }

    /**
     * @param Response $response
     *
     * @return mixed
     */
    protected function getResponseData(Response $response)
    {
        $content = json_decode($response->getBody(), true);

        if (!$content)
        {
            // @todo Handle invalid JSON error.
        }

        return $content;
    }

    /**
     * @param        $endpoint
     * @param array  $data
     * @param string $method
     *
     * @return Response
     */
    protected function performRequest($endpoint, $data = [], $method = 'GET')
    {
        $client = new Client();

        $request_options = [];

        $request_options['auth'] = [$this->api_key, $this->api_secret];

        if (!empty($data))
        {
            $request_options['json'] = $data;
        }

        /** @var Response $res */
        $res = $client->request($method, $endpoint, $request_options);

        return $res;
    }
}