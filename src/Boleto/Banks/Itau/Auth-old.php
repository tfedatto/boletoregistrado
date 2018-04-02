<?php
/**
 * Created by PhpStorm.
 * User: tiago_fedatto
 * Date: 02/04/18
 * Time: 10:01
 */

namespace Banks\Itau;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class old
{
    private $token;
    private $url;
    private $client_id;
    private $cliente_secret;
    private $environment;


    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClienteSecret()
    {
        return $this->cliente_secret;
    }

    /**
     * @param mixed $cliente_secret
     */
    public function setClienteSecret($cliente_secret)
    {
        $this->cliente_secret = $cliente_secret;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param mixed $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    public function setConfig($config){
        $this->setEnvironment($config['tipo_ambiente'])
            ->setClienteSecret($config['client_secret'])
            ->setClientId($config['client_id']);

        $url = 'https://oauth.itau.com.br/identity/connect/token';

        if($config['tipo_ambiente'] == 2){
            $url = 'https://autorizador-boletos.itau.com.br';
        }

        $this->setUrl($url);
    }


    public function requestToken(){
        try{

            $response = new Request('POST', $this->getUrl(), [
                'form_params' => [
                    'scope' => 'readonly',
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->getClientId(),
                    'client_secret' => $this->getClienteSecret()
                ]
            ]);

            if($response->getStatusCode() != 200){
                throw new Exception('O Token não foi gerado!');
            }
            return $response->getBody();

        }catch (Exception $e){
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\str($e->getResponse());
            }
        }
    }
}