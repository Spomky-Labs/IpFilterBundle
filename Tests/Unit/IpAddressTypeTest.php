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
            '\Doctrine\DBAL\Platforms\DB2Platform',
            '\Doctrine\DBAL\Platforms\DrizzlePlatform',
            '\Doctrine\DBAL\Platforms\MySqlPlatform',
            '\Doctrine\DBAL\Platforms\OraclePlatform',
            '\Doctrine\DBAL\Platforms\PostgreSqlPlatform',
            '\Doctrine\DBAL\Platforms\SQLAzurePlatform',
            '\Doctrine\DBAL\Platforms\SQLServer2005Platform',
            '\Doctrine\DBAL\Platforms\SQLServer2008Platform',
            '\Doctrine\DBAL\Platforms\SQLServer2012Platform',
            '\Doctrine\DBAL\Platforms\SQLServerPlatform',
            '\Doctrine\DBAL\Platforms\SqlitePlatform',
            '\Doctrine\DBAL\Platforms\MySQL57Platform',
            '\Doctrine\DBAL\Platforms\PostgreSQL91Platform',
            '\Doctrine\DBAL\Platforms\PostgreSQL92Platform',
            '\Doctrine\DBAL\Platforms\SQLAnywhere11Platform',
            '\Doctrine\DBAL\Platforms\SQLAnywhere12Platform',
            '\Doctrine\DBAL\Platforms\SQLAnywhere16Platform',
            '\Doctrine\DBAL\Platforms\SQLAnywherePlatform',
        );

        $values = array(
            array(null, null),
            array('127.0.0.1','7f000001'),
            array('fe80::abcd:0:1234:5678','fe80000000000000abcd000012345678'),
        );

        $test_cases = array();
        foreach ($platforms as $platform) {
            if (class_exists($platform)) {
                foreach ($values as $value) {
                    $test_cases[] = array(
                        new $platform,
                        $value[0],
                        $value[1],
                    );
                }
            }
        }

        return $test_cases;
    }
}
