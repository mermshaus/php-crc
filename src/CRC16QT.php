<?php

namespace mermshaus\CRC;

/**
 * Implements the CRC16_CCITT algorithm used in QT algorithms
 */
class CRC16QT extends CRC16CCITT
{
    protected $xorMask = 0xffff;

    protected $reverseCRCResult = true;

    protected $reverseData = true;

    protected function reverseByte($byte)
    {
        $ob = 0;
        $b = (1 << 7);

        for ($i = 0; $i <= 7; $i++) {
            if (($byte & $b) !== 0) {
                $ob |= (1 << $i);
            }
            $b >>= 1;
        }

        return $ob;
    }

    protected function reverseBits($cc)
    {
        $ob = 0;
        $b = (1 << 15);

        for ($i = 0; $i <= 15; $i++) {
            if (($cc & $b) !== 0) {
                $ob |= (1 << $i);
            }
            $b >>= 1;
        }

        return $ob;
    }

    public function update($data)
    {
        $len = strlen($data);

        for ($i = 0; $i < $len; $i++) {
            $byte = ($this->reverseData)
                ? $this->reverseByte(ord($data[$i]))
                : ord($data[$i]);

            $this->checksum = ($this->lookup[(($this->checksum >> 8) ^ $byte) & 0xff] ^ ($this->checksum << 8)) & 0xffff;
        }
    }

    protected function getChecksum()
    {
        $checksum = $this->checksum;
        $checksum ^= $this->xorMask;

        if ($this->reverseCRCResult) {
            $checksum = $this->reverseBits($checksum);
        }

        return $checksum;
    }
}
