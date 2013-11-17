<?php

/*
 * Doctrine Extension Function
 */

namespace Spomky\IpFilterBundle\Doctrine\Query;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

class Convert extends FunctionNode
{
    public $stringFirst;
    public $stringSecond;
    public $stringThird; 

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); 
        $parser->match(Lexer::T_OPEN_PARENTHESIS); 
        $this->stringFirst = $parser->StringPrimary(); 
        $parser->match(Lexer::T_COMMA);
        $this->stringSecond = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->stringThird = $parser->ArithmeticPrimary();      
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'CONV(' . 
            $this->stringFirst->dispatch($sqlWalker) . 
            ',' . $this->stringSecond->dispatch($sqlWalker) .
            ',' . $this->stringThird->dispatch($sqlWalker) . ')'; 
    }
}
