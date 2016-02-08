<?php


namespace MJErwin\SendOwl\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use MJErwin\SendOwl\Exception\EntityNotFoundException;
use MJErwin\SendOwl\Exception\EntityInvalidException;


/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class SendOwlApi implements SendOwlApiInterface
{
    protected $api_key;
    protected $api_secret;

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

            throw $e;
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

            throw $e;
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

            throw $e;
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
            var_dump($e->getCode());
            if ($e->getCode() == 404)
            {
                throw new EntityNotFoundException($entity_type, $id);
            }

            throw $e;
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
     * @param        string $endpoint
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