<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\IpFilterBundle\Features\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

/**
 * Behat context class.
 */
class FeatureContext extends MinkContext implements KernelAwareContext, SnippetAcceptingContext
{
    private $kernel;

    /**
     * @var null|\Exception
     */
    private $exception = null;

    /**
     * @var \SpomkyLabs\IpFilterBundle\Features\Context\RequestBuilder
     */
    private $request_builder;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->request_builder = new RequestBuilder();
    }

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

        return $this;
    }

    public function getKernel()
    {
        return $this->kernel;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function getRequestBuilder()
    {
        return $this->request_builder;
    }

    public function addKeyWithValueInTheHeader($key, $value)
    {
        $this->request_builder->addHeader($key, $value);
    }

    public function addKeyWithValueInTheQueryParameter($key, $value)
    {
        $this->request_builder->addQueryParameter($key, $value);
    }

    public function addKeyWithValueInTheServerParameter($key, $value)
    {
        $this->request_builder->addServerParameter($key, $value);
    }

    public function addKeyWithValueInTheBodyRequest($key, $value)
    {
        $this->request_builder->addContentParameter($key, $value);
    }

    /**
     * @Given the request is not secured
     */
    public function theRequestIsNotSecured()
    {
        $this->request_builder->addServerParameter('HTTPS', 'off');
    }

    /**
     * @Given the request is secured
     */
    public function theRequestIsSecured()
    {
        $this->request_builder->addServerParameter('HTTPS', 'on');
    }

    /**
     * @When I :method the request to :uri
     *
     * @param string $method
     */
    public function iTheRequestTo($method, $uri)
    {
        $client = $this->getSession()->getDriver()->getClient();
        $client->followRedirects(false);

        $this->getRequestBuilder()->setUri($this->locatePath($uri));
        try {
            $client->request(
                $method,
                $this->getRequestBuilder()->getUri(),
                [],
                [],
                $this->getRequestBuilder()->getServerParameters(),
                $this->getRequestBuilder()->getContent()
            );
        } catch (\Exception $e) {
            $this->exception = $e;
        }
        $client->followRedirects(true);
    }

    /**
     * @Then I should not receive an exception
     */
    public function iShouldNotReceiveAnException()
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }
    }

    /**
     * @Given my IP address is :ip
     */
    public function myIpAddressIs($ip)
    {
        $this->addKeyWithValueInTheServerParameter('REMOTE_ADDR', $ip);
    }

    /**
     * @Then I should be denied
     */
    public function iShouldBeDenied()
    {
        if (!$this->exception instanceof InsufficientAuthenticationException) {
            throw new \Exception('I should have an Insufficient Authentication Exception.');
        }
    }

    /**
     * @Then I should be granted
     */
    public function iShouldBeGranted()
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }
    }
}
