<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\IpFilterBundle\Tool;

class Network
{
    public static function getRange($network)
    {
        try {
            list($ip, $cidr) = explode('/', $network);
        } catch (\Exception $e) {
            throw new \Exception('Invalid IP/CIDR combination supplied');
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return self::getIPv4Range($ip, $cidr);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return self::getIPv6Range($ip, $cidr);
        }

        throw new \Exception('Invalid IP/CIDR combination supplied');
    }

    protected static function getIPv4Range($ip, $cidr)
    {
        if ($cidr < 0 || $cidr > 32) {
            throw new \Exception('Invalid network, IPv4 CIDR must be between 0 and 32.');
        }

        $ipLong = ip2long($ip);
        $ipMaskLong = bindec(str_repeat('1', $cidr).str_repeat('0', 32 - $cidr));
        $network = $ipLong & $ipMaskLong;
        $broadcast = $ipLong | ~$ipMaskLong;

        return [
            'start'     => long2ip($network + 1),
            'end'       => long2ip($broadcast - 1),
            'network'   => long2ip($network),
            'mask'      => long2ip($ipMaskLong),
            'broadcast' => long2ip($broadcast),
        ];
    }

    protected static function getIPv6Range($ip, $cidr)
    {
        if ($cidr < 0 || $cidr > 128) {
            throw new \Exception('Invalid network, IPv6 CIDR must be between 0 and 128.');
        }

        $hosts = 128 - $cidr;
        $networks = 128 - $hosts;

        $_m = str_repeat('1', $networks).str_repeat('0', $hosts);

        $_hexMask = '';
        foreach (str_split($_m, 4) as $segment) {
            $_hexMask .= base_convert($segment, 2, 16);
        }

        $mask = substr(preg_replace('/([A-f0-9]{4})/', '$1:', $_hexMask), 0, -1);

        $ip_bin = inet_pton($ip);
        $mask_bin = inet_pton($mask);

        $network = $ip_bin & $mask_bin;
        $broadcast = $ip_bin | ~$mask_bin;

        return [
            'start' => self::convertBinaryToPrintable($network),
            'end'   => self::convertBinaryToPrintable($broadcast),
        ];
    }

    /**
     * @param string $str
     */
    protected static function convertBinaryToPrintable($str)
    {
        return inet_ntop(pack('A'.strlen($str), $str));
    }
}
