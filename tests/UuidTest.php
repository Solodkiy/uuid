<?php

namespace Solodkiy\Uuid;

use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testGenerate()
    {
        $a = Uuid::generate();
        $b = Uuid::generate();

        $this->assertLessThan($b->getHex(), $a->getHex());
    }

    public function testPack()
    {
        $a = Uuid::generate();
        $bytes = $a->getBinary();
        $b = Uuid::createFromBinary($bytes);

        $this->assertEquals($a, $b);
    }
}