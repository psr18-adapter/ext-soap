<?php

declare(strict_types=1);

namespace Psr18Adapter\Soap;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SoapPsr18Client extends \SoapClient
{
    /**
     * @var ClientInterface
     */
    private $httpClient;
    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;
    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $wsdl,
        array $options = []
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;

        parent::__construct($wsdl, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function __doRequest($body, $location, $action, $version, $one_way = 0): string
    {
        $request = $this->requestFactory->createRequest('POST', $location);

        if ($version === SOAP_1_1) {
            $request = $request
                ->withHeader('Content-Type', 'text/xml; charset=utf-8')
                ->withHeader('SOAPAction', $action);
        } else {
            $request = $request->withHeader(
                'Content-Type',
                sprintf('application/soap+xml; charset=utf-8; action="%s"', $action)
            );
        }

        $response = $this->httpClient->sendRequest($request->withBody($this->streamFactory->createStream($body)));

        return $response->getBody()->getContents();
    }
}