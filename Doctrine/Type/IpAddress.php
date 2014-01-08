<?php

namespace Spomky\IpFilterBundle\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
* Type that maps an Ip Address SQL to php objects
* @author Florent Morselli
*/
class IpAddress extends Type
{
    const IPADDRESS = 'ipaddress';

    public function getName()
    {
        return self::IPADDRESS;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        switch ($platform->getName()) {
            case 'sqlite':
                return $platform->getDoctrineTypeMapping('VARCHAR');
                break;
            case 'mysql':
            case 'oracle':
            case 'drizzle':
            case 'db2':
            case 'sqlanywhere':
            case 'mssql':
                return $platform->getDoctrineTypeMapping('VARBINARY');
                break;
            case 'postgresql':
                return $platform->getDoctrineTypeMapping('BYTEA');
                break;
            default:
                throw new \Exception("Database platform '".$platform->getName()."' not supported.");
                break;
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return ($value === null) ? null : bin2hex(inet_pton($value));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if( function_exists('hex2bin') ) {
            // PHP 5.4+
            return ($value === null) ? null : hex2bin($value);
        }

        return ($value === null) ? null : inet_ntop(pack("H*",$value));
    }
}
