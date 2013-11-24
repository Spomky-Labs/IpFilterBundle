<?php

namespace Spomky\IpFilterBundle\Model;

interface IpInterface
{
    public function getIp();
    public function getEnvironment();
    public function isAuthorized();
}
