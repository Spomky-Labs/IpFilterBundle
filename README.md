Ip Filter Bundle
================

**This project was forked from [Spomky-Labs/IpFilterBundle](https://github.com/Spomky-Labs/IpFilterBundle) because is abandoned.**

[![Build Status](https://travis-ci.org/Spomky-Labs/IpFilterBundle.png?branch=master)](https://travis-ci.org/Spomky-Labs/IpFilterBundle)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Spomky-Labs/IpFilterBundle/badges/quality-score.png?s=801f9afe962a2ef962fa13e5bba55d2e57aa68f8)](https://scrutinizer-ci.com/g/Spomky-Labs/IpFilterBundle/)
[![HHVM Status](http://hhvm.h4cc.de/badge/spomky-labs/ip-filter-bundle.png)](http://hhvm.h4cc.de/package/spomky-labs/ip-filter-bundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a9c8daca-709b-4798-98f8-9a4adc592c4e/big.png)](https://insight.sensiolabs.com/projects/a9c8daca-709b-4798-98f8-9a4adc592c4e)

[![Latest Stable Version](https://poser.pugx.org/spomky-labs/ip-filter-bundle/v/stable.png)](https://packagist.org/packages/spomky-labs/ip-filter-bundle)
[![Total Downloads](https://poser.pugx.org/spomky-labs/ip-filter-bundle/downloads.png)](https://packagist.org/packages/spomky-labs/ip-filter-bundle)
[![Latest Unstable Version](https://poser.pugx.org/spomky-labs/ip-filter-bundle/v/unstable.png)](https://packagist.org/packages/spomky-labs/ip-filter-bundle)
[![License](https://poser.pugx.org/spomky-labs/ip-filter-bundle/license.png)](https://packagist.org/packages/spomky-labs/ip-filter-bundle)

This bundle will help you to restrict access of your application using `IP addresses` and `ranges of IP addresses`.

It supports both `IPv4` and `IPv6` addresses and multiple environments.

For example, you can grant access of a range of addresses from `192.168.1.1` to `192.168.1.100` on `dev` and `test` environments and deny all others.

**Please note that this bundle has bad results in term of performance compared to similar functionality offered by a `.htaccess` file for example.** 

# Prerequisites #

This version of the bundle requires at least `Symfony 2.3`.
It requires `Doctrine`. `Doctrine ORM` is supported, but it may be easy to use `Doctrine ODM` for example.

At has been tested using `PHP 5.3` to `PHP 5.6` and `HHVM` using `Symfony 2.3` to `Symfony 2.6)`.

# Policy #

Please note that authorized IPs have a higher priority than unauthorized ones.
For example, if range `192.168.1.10` to `192.168.1.100` is **unauthorized** and `192.168.1.20` is **authorized**, then `192.168.1.20` will be granted. 

# Installation #

Installation is a quick 4 steps process:

* Download the bundle`
* Enable the Bundle
* Create your model class
* Configure the application

##Step 1: Install the bundle##

The preferred way to install this bundle is to rely on Composer:

```sh
composer require "spomky-labs/ip-filter-bundle" "~2.0"
```

##Step 2: Enable the bundle##

Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new SpomkyLabs\IpFilterBundle\SpomkyLabsIpFilterBundle(),
    );
}
```

##Step 3: Create IP and Range classes##

This bundle needs a database to persist filtered IPs and ranges.

Your first job, then, is to create `Ip` and `Range` classes for your application.
These classes can look and act however you want: add any properties or methods you find useful.

In the following sections, you'll see an example of how your classes should look.

Your classes can live inside any bundle in your application.
For example, if you work at "Acme" company, then you might create a bundle called `AcmeIpBundle` and place your classes in it.

###Ip class:###

```php
<?php
// src/Acme/IpBundle/Entity/Ip.php

namespace Acme\IpBundle\Entity;

use SpomkyLabs\IpFilterBundle\Entity\Ip as BaseIp;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ip
 *
 * @ORM\Table(name="ips")
 */
class Ip extends BaseIp
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
```


**Easy!**
-

```php
<?php
// src/Acme/IpBundle/Entity/Range.php

namespace Acme\IpBundle\Entity;

use SpomkyLabs\IpFilterBundle\Entity\Range as BaseRange;
use Doctrine\ORM\Mapping as ORM;

/**
 * Range
 *
 * @ORM\Table(name="ranges")
 */
class Range extends BaseRange
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
```

##Step 4: Configure your application##

### Set your classes and managers ###

```yml
# app/config/config.yml
sl_ip_filter:
    ip_class:             Acme\IpBundle\Entity\Ip
    range_class:          Acme\IpBundle\Entity\Range
```

If you have your own managers, you can use them. They just need to implement `SpomkyLabs\IpFilterBundle\Model\IpManagerInterface` or `SpomkyLabs\IpFilterBundle\Model\RangeManagerInterface`.

```yml
# app/config/config.yml
sl_ip_filter:
    ...
    ip_manager: my.custom.ip.entity_manager
    range_manager: my.custom.range.entity_manager
```

###Security Strategy###

In order for this bundle to take effect, you need to change the default access decision strategy, which, by default, grants access if any voter grants access.

You also need to place your site behind a firewall rule.

```yml
# app/config/security.yml
security:
    access_decision_manager:
        strategy: unanimous
…
firewalls: 
    my_site:
        pattern: ^/
        anonymous: ~

access_control:
    - { path: ^/, roles: IS_AUTHENTICATED_ANONYMOUSLY }
```

# How to #

## Small example ##

How to grant access for `192.168.1.10` on `dev` and `test` environments and deny all others?

```php
<?php

$ip_manager    = $this->container->get('sl_ip_filter.ip_manager'); //Use this line, even if you use a custom IP manager
$range_manager = $this->container->get('sl_ip_filter.range_manager'); //Use this line, even if you use a custom Range manager

//Create your IP
$ip = $ip_manager->createIp();
$ip->setIp('192.168.1.10')
   ->setEnvironment('dev,test')
   ->setAuthorized(true);
$ip_manager->saveIp($ip);

//Create your range
$range = $range_manager->createRange();
$range->setStartIp('0.0.0.1')
      ->setEndIp('255.255.254')
      ->setEnvironment('dev,test')
      ->setAuthorized(false);
$range_manager->saveRange($range);
```

## Network support ##

Networks can be supported using a Range object. You just need to get first and last IP addresses.
This bundle provides a range calculator, so you can easily extend your range entity using it.

```php
<?php

$range_manager = $this->container->get('sl_ip_filter.range_manager');

//All addresses (IPv4)
$range1 = $range_manager->createRangeFromNetwork('0.0.0.0/0');
$range1->setEnvironment('dev,test')
       ->setAuthorized(false);
$range_manager->saveRange($range1);

//My local network (IPv4)
$range2 = $range_manager->createRangeFromNetwork('192.168.0.0/16');
$range2->setEnvironment('dev,test')
       ->setAuthorized(true);
$range_manager->saveRange($range2);

//Another local network (IPv6)
$range3 = $range_manager->createRangeFromNetwork('fe80::/64');
$range3->setEnvironment('dev,test')
       ->setAuthorized(true);
$range_manager->saveRange($range3);
```
