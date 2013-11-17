<?php

/*
 * Doctrine Extension Function
 */

namespace Spomky\IpFilterBundle\Doctrine\Query;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * "IP" "(" StringPrimary ")"
 */
class IPAddress extends FunctionNode
{
    public $ip = null;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->ip = $parser->StringPrimary();
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'INET_ATON(' .
            $this->ip->dispatch($sqlWalker) .
        ')';
    }
}
