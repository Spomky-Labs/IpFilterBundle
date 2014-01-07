<?php

namespace Spomky\IpFilterBundle\Tool;

class Network
{
    public function getRange($network)
    {
        list($ip, $cidr) = explode('/', $network);

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {

            return $this->getIPv4Range($ip, $cidr);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {

            return $this->getIPv6Range($ip, $cidr);
        }

        throw new \Exception("Invalid IP/CIDR combination supplied");
    }

    private function getIPv4Range($ip, $cidr)
    {

        if( $cidr < 0 || $cidr > 32 )
            throw new \Exception("Invalid network, IPv4 CIDR must be between 0 and 32.");

        $ipLong = ip2long( $ip );
        $ipMaskLong = bindec( str_repeat("1", $cidr ) . str_repeat("0", 32-$cidr ) );
        $network = $ipLong & $ipMaskLong;
        $broadcast = $ipLong | ~ $ipMaskLong;

        return array(
            'start' => long2ip($network+1),
            'end' => long2ip($broadcast -1),
        );
    }

    private function getIPv6Range($ip, $cidr)
    {

        if( $cidr < 0 || $cidr > 128 )
            throw new \Exception("Invalid network, IPv6 CIDR must be between 0 and 128.");
        
        $hosts    = 128 - $cidr;
        $networks = 128 - $hosts;

        $_m = str_repeat("1", $networks).str_repeat("0", $hosts);

        $_hexMask = null;
        foreach ( str_split( $_m, 4) as $segment) {

            $_hexMask .= base_convert( $segment, 2, 16);
        }

        $mask = substr(preg_replace("/([A-f0-9]{4})/", "$1:", $_hexMask), 0, -1);

        $ip_bin = $this->dtr_pton($ip);
        $mask_bin = $this->dtr_pton($mask);

        $network = $ip_bin & $mask_bin;
        $broadcast = $ip_bin | ~ $mask_bin;

        return array(
            'start' => $this->dtr_ntop($network),
            'end' => $this->dtr_ntop($broadcast),
        );
    }

    private function dtr_pton($ip)
    {
        return current( unpack( "A16", inet_pton( $ip ) ) );
    }

    private function dtr_ntop($str)
    {
        return inet_ntop( pack( "A".strlen( $str ) , $str ) );
    }
}
