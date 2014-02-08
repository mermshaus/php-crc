<?php

namespace mermshaus\CRC;

abstract class AbstractCRC implements CRCInterface
{
    /**
     *
     * @var int
     * @internal
     */
    protected $checksum;

    /**
     *
     * @var int
     * @internal
     */
    protected $initChecksum = 0x0;

    /**
     *
     * @var int
     * @internal
     */
    protected $xorMask = 0x0;

    public function __construct()
    {
        $this->reset();
    }

    public function finish()
    {
        return $this->pack($this->getChecksum());
    }

    public function reset()
    {
        $this->checksum = $this->initChecksum;
    }

    /**
     *
     * @internal
     */
    protected function getChecksum()
    {
        return $this->checksum ^ $this->xorMask;
    }

    /**
     *
     * @internal
     */
    abstract protected function pack($checksum);
}
