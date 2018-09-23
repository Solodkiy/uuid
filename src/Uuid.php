<?php

namespace Solodkiy\Uuid;

final class Uuid implements \JsonSerializable
{
    private $binary;

    public static function generate()
    {
        ['sec' => $seconds, 'usec' => $microSeconds] = gettimeofday();
        $head = ($seconds * 10000000) + ($microSeconds * 10);
        $tail = random_bytes(8);
        $binary = pack('J*', $head) . $tail;

        return new static($binary);
    }

    public static function createFromBinary(string $binary)
    {
        return new static($binary);
    }

    public function equals(Uuid $id)
    {
        return $this->binary === $id->binary;
    }

    private function __construct(string $binary)
    {
        if (strlen($binary) !== 16) {
            throw new \InvalidArgumentException('Expected 16 bytes');
        }
        $this->binary = $binary;
    }

    public function getHex(): string
    {
        return strtoupper(bin2hex($this->binary));
    }

    public function getBase64()
    {
        return base64_encode($this->binary);
    }

    public function __debugInfo()
    {
        return [
            'data' => $this->getBase64()
        ];
    }

    /**
     * @return string
     */
    public function getBinary(): string
    {
        return $this->binary;
    }

    public function __toString()
    {
        return $this->getBase64();
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->getBase64();
    }
}
