<?php
/**
 * Created by PhpStorm.
 * User: piotrzatorski
 * Date: 17/10/2018
 * Time: 17:11
 */

namespace App\Helper;

use App\Request\Request;
use GuzzleHttp\Exception\RequestException;

class RequestHelper
{
    /**
     * @var Request|null
     */
    private $request;

    /**
     * @var array
     */
    private $requestParams;

    /**
     * RequestHelper constructor.
     */
    public function __construct()
    {
        $this->requestParams = [
            //                'http_errors' => false,
        ];
    }


    /**
     * Nowadays its alias but can be used to extend other checks
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkUrl(): void
    {
        $this->catchRequestException();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function catchRequestException(): void
    {
        try {
            $this->getRequest()->getClient()->request(
                    'GET',
                    $this->getRequest()->getUrl(),
                    $this->requestParams
            );
        } catch (RequestException $e) {
            die("RequestException thrown. In the event of a networking error (connection timeout, DNS errors, etc.) <br> Url: ".  $this->request->getUrl());
        }
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return Request
     */
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }


}