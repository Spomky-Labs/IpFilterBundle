Ip Filter
=========

[![Build Status](https://travis-ci.org/Spomky/SpomkyIpFilterBundle.png?branch=master)](https://travis-ci.org/Spomky/SpomkyIpFilterBundle)

This bundle will help you to restrict access of your application using IP addresses and ranges of IP addresses.

It supports both IPv4 and IPv6 addresses.


# Prerequisites #

This version of the bundle requires Symfony 2.1.
It only supports Doctrine ORM.

# Policies #

This bundle supports two policies: blacklist and whitelist.

If you choose blacklist, all requests from an IP or an IP in a range stored in the database will be denied.

If whitelist, only those stored in database will be granted.

# Installation #

Installation is a quick 4 steps process:

* Download SpomkyIpFilterBundle
* Enable the Bundle
* Create your model class
* Configure the SpomkyIpFilterBundle

##Step 1: Install SpomkyIpFilterBundle##

The preferred way to install this bundle is to rely on Composer. Just check on Packagist the version you want to install (in the following example, we used "dev-master") and add it to your composer.json:

	{
	    "require": {
	        // ...
	        "spomky/ip-filter-bundle": "dev-master"
	    }
	}

##Step 2: Enable the bundle##

Finally, enable the bundle in the kernel:

	<?php
	// app/AppKernel.php
	
	public function registerBundles()
	{
	    $bundles = array(
	        // ...
	        new Spomky\IpFilterBundle\SpomkyIpFilterBundle(),
	    );
	}

##Step 3: Create IP and Range classes##

This bundle needs to persist filtered IPs and ranges to a database:

Your first job, then, is to create these classes for your application.
These classes can look and act however you want: add any properties or methods you find useful.

In the following sections, you'll see an example of how your classes should look.

Your classe can live inside any bundle in your application.
For example, if you work at "Acme" company, then you might create a bundle called AcmeIpBundle and place your classes in it.

Ip Repository and Range Repository classes are important. You can use those provided wwith this bundle or extend them to include your own classes.

The IP field type must be "ipaddress".

###Ip class:###

	<?php
	// src/Acme/IpBundle/Entity/Ip.php
	
	namespace Acme\IpBundle\Entity;
	
	use Spomky\IpFilterBundle\Model\Ip as BaseIp;
	use Doctrine\ORM\Mapping as ORM;
	
	/**
	 * Ip
	 *
	 * @ORM\Table(name="ips")
	 * @ORM\Entity(repository="Spomky\IpFilterBundle\Model\IpRepository")
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
	
	    /**
	     * @var ipaddress $ip
	     *
	     * @ORM\Column(name="ip", type="ipaddress")
	     */
	    protected $ip;
	
	    public function getId() {
	        return $this->id;
	    }
	
	    public function setIp($ip) {
	        $this->ip = $ip;
	        return $this;
	    }
	}

-

	<?php
	// src/Acme/IpBundle/Entity/Range.php
	
	namespace Acme\IpBundle\Entity;
	
	use Spomky\IpFilterBundle\Model\Range as BaseRange;
	use Doctrine\ORM\Mapping as ORM;
	
	/**
	 * Range
	 *
	 * @ORM\Table(name="ranges")
	 * @ORM\Entity(repositoryClass="Spomky\IpFilterBundle\Model\RangeRepository")
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
	
	    /**
	     * @var ipaddress $start_ip
	     *
	     * @ORM\Column(name="start_ip", type="ipaddress")
	     */
	    protected $start_ip;
	
	    /**
	     * @var ipaddress $end_ip
	     *
	     * @ORM\Column(name="end_ip", type="ipaddress")
	     */
	    protected $end_ip;
	
	    public function getId() {
	        return $this->id;
	    }
	
	    public function setStartIp($start_ip) {
	        $this->start_ip = $start_ip;
	        return $this;
	    }
	
	    public function setEndIp($end_ip) {
	        $this->end_ip = $end_ip;
	        return $this;
	    }
	}

##Step 4: Configure your application##

### Set your classes and managers ###

	# app/config/config.yml
	spomky_ip_filter:
	    policy:    blacklist  # Policies available: blacklist, whitelist
	    db_driver: orm        # Driver available: orm
	    ip_class:             Acme\IpBundle\Entity\Ip
	    range_class:          Acme\IpBundle\Entity\Range

If you have your own managers, you can use them. It just needs to implement Spomky\IpFilterBundle\Model\IpManagerInterface or Spomky\IpFilterBundle\Model\RangeManagerInterface.

	# app/config/config.yml
	spomky_ip_filter:
	    ...
	    ip_manager: my.custom.ip.manager
	    range_manager: my.custom.range.manager

###Change the Access Decision Strategy###

In order for this bundle to take effect, you need to change the default access decision strategy, which, by default, grants access if any voter grants access.

In this case, choose the unanimous strategy:

    # app/config/security.yml
    security:
        access_decision_manager:
            strategy: unanimous

###Add DQL custom expression support ###

	# app/config/config.yml
    orm:
        #...
        entity_managers:
            default:
                dql:
                    string_functions:
                        conv: Spomky\IpFilterBundle\Query\Convert