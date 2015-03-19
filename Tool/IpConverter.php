<?php

namespace SpomkyLabs\IpFilterBundle\Tool;

class IpConverter
{
    public static function fromIpToHex($ip)
    {
        $hex = bin2hex(inet_pton($ip));
        if (8 === strlen($hex)) {
            $hex = str_pad($hex, 32, '0',STR_PAD_LEFT);
        }
        return $hex;
    }

    public static function fromHexToIp($ip)
    {
        $hex = pack("H*", $ip);
        if (str_repeat('0',24) === substr($hex,0,24)) {
            $hex = substr($hex,24);
        }
        return inet_ntop($hex);
    }
}
