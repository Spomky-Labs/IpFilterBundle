<?php

namespace Spomky\IpFilterBundle\Tests\Unit;

use Spomky\IpFilterBundle\Doctrine\Type\IpAddress;
use Doctrine\DBAL\Types\Type;

class IpAddressTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $obj = Type::getType('ipaddress');

        $this->assertEquals($obj->getName(), IpAddress::IPADDRESS);
    }
    
    /**
     * @dataProvider dataSQLDeclaration
     */
    public function testSQLDeclaration(\Doctrine\DBAL\Platforms\AbstractPlatform $platform, $expected_type)
    {
        $obj = Type::getType('ipaddress');

        $this->assertEquals($obj->getSQLDeclaration(array(), $platform), $expected_type);
    }

    /**
     * Dataprovider for testSQLDeclaration().
     */
    public function dataSQLDeclaration()
    {
        $platforms = array(
            '\Doctrine\DBAL\Platforms\DB2Platform' => 'string',
            '\Doctrine\DBAL\Platforms\DrizzlePlatform' => 'string',
            '\Doctrine\DBAL\Platforms\MySqlPlatform' => 'blob',
            '\Doctrine\DBAL\Platforms\OraclePlatform' => 'blob',
            '\Doctrine\DBAL\Platforms\PostgreSqlPlatform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLAzurePlatform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLServer2005Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLServer2008Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLServer2012Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLServerPlatform' => 'blob',
            '\Doctrine\DBAL\Platforms\SqlitePlatform' => 'string',
            '\Doctrine\DBAL\Platforms\MySQL57Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\PostgreSQL91Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\PostgreSQL92Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLAnywhere11Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLAnywhere12Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLAnywhere16Platform' => 'blob',
            '\Doctrine\DBAL\Platforms\SQLAnywherePlatform' => 'blob',
        );

        $test_cases = array();
        foreach ($platforms as $key => $value) {
            if (class_exists($key)) {
                $test_cases[] = array(
                    new $key,
                    $value,
                );
            }
        }
        
        return $test_cases;
    }

    /**
     * @dataProvider dataSQLConvert
     */
    public function testSQLConvert(\Doctrine\DBAL\Platforms\AbstractPlatform $platform, $value, $expected_value)
    {
        $obj = Type::getType('ipaddress');

        $converted = $obj->convertToDatabaseValue($value, $platform);

        $this->assertEquals($converted, $expected_value);
        $this->assertEquals($value, $obj->convertToPHPValue($converted, $platform));
    }

    /**
     * Dataprovider for testSQLConvert().
     */
    public function dataSQLConvert()
    {
        $platforms = array(
            '\Doctrine\DBAL\Platforms\DB2Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\DrizzlePlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\MySqlPlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\OraclePlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\PostgreSqlPlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLAzurePlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLServer2005Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLServer2008Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLServer2012Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLServerPlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SqlitePlatform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\MySQL57Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\PostgreSQL91Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\PostgreSQL92Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLAnywhere11Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLAnywhere12Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLAnywhere16Platform' => array('127.0.0.1','7f000001'),
            '\Doctrine\DBAL\Platforms\SQLAnywherePlatform' => array('127.0.0.1','7f000001'),

            '\Doctrine\DBAL\Platforms\DB2Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\DrizzlePlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\MySqlPlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\OraclePlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\PostgreSqlPlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLAzurePlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLServer2005Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLServer2008Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLServer2012Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLServerPlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SqlitePlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\MySQL57Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\PostgreSQL91Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\PostgreSQL92Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLAnywhere11Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLAnywhere12Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLAnywhere16Platform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
            '\Doctrine\DBAL\Platforms\SQLAnywherePlatform' => array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
        );

        $test_cases = array();
        foreach ($platforms as $key => $value) {
            if (class_exists($key)) {
                $test_cases[] = array(
                    new $key,
                    $value[0],
                    $value[1],
                );
            }
        }

        return $test_cases;
    }
}
