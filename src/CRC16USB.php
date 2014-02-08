<?php

namespace mermshaus\CRC;

class CRC16USB extends \mermshaus\CRC\CRC16
{
    protected $initChecksum = 0xffff;
    protected $xorMask = 0xffff;
}
