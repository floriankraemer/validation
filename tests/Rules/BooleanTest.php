<?php

declare(strict_types=1);

namespace Somnambulist\Components\Validation\Tests\Rules;

use PHPUnit\Framework\TestCase;
use Somnambulist\Components\Validation\Rules\TypeBoolean;

class BooleanTest extends TestCase
{
    public function setUp(): void
    {
        $this->rule = new TypeBoolean();
    }

    public function testValids()
    {
        $this->assertTrue($this->rule->check(\true));
        $this->assertTrue($this->rule->check(\false));
        $this->assertTrue($this->rule->check(1));
        $this->assertTrue($this->rule->check(0));
        $this->assertTrue($this->rule->check('1'));
        $this->assertTrue($this->rule->check('0'));
        $this->assertTrue($this->rule->check('y'));
        $this->assertTrue($this->rule->check('n'));
    }

    public function testInvalids()
    {
        $this->assertFalse($this->rule->check(11));
        $this->assertFalse($this->rule->check([]));
        $this->assertFalse($this->rule->check('foo123'));
        $this->assertFalse($this->rule->check('123foo'));
        $this->assertFalse($this->rule->check([123]));
        $this->assertFalse($this->rule->check('123.456'));
        $this->assertFalse($this->rule->check('-123.456'));
    }
}
