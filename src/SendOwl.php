<?php


namespace MJErwin\SendOwl;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use MJErwin\SendOwl\Api\SendOwlApi;
use MJErwin\SendOwl\Api\SendOwlApiInterface;
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
    /** @var SendOwlApiInterface */
    protected $api;

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

    public function getApi()
    {
        if (!$this->api instanceof SendOwlApiInterface)
        {
            $this->api = new SendOwlApi();
            $this->api->authenticate($this->api_key, $this->api_secret);
        }

        return $this->api;
    }

    public function setApi(SendOwlApiInterface $api)
    {
        $this->api = $api;

        return $this;
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

        $this->getApi()->authenticate($api_key, $api_secret);

        return $this;
    }

    public function hasAuthenticationData()
    {
        return $this->api_key && $this->api_secret ? true : false;
    }

    /**
     * @param array  $request_data
     * @param string $signature
     *
     * @return bool
     */
    public function isSignatureValid($request_data, $signature)
    {
        if (!$request_data)
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
        return $this->getApi()->fetchEntitiesData($entity_type);
    }

    /**
     * @param $entity_type
     * @param $id
     *
     * @return mixed
     */
    public function fetchEntityData($entity_type, $id)
    {
        return $this-$this->getApi()->fetchEntityData($entity_type, $id);
    }

    /**
     * @param $entity_type
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function updateEntity($entity_type, $id, $data)
    {
        return $this->getApi()->updateEntity($entity_type, $id, $data);
    }

    /**
     * @param $entity_type
     * @param $data
     *
     * @return mixed
     */
    public function createEntity($entity_type, $data)
    {
        return $this->getApi()->createEntity($entity_type, $data);
    }

    /**
     * @param $entity_type
     * @param $id
     *
     * @return mixed
     */
    public function deleteEntity($entity_type, $id)
    {
        return $this->getApi()->deleteEntity($entity_type, $id);
    }
}