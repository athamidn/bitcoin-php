<?php

namespace BitWasp\Bitcoin\Network\Messages;

use BitWasp\Bitcoin\Buffer;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Network\NetworkSerializable;
use BitWasp\Bitcoin\Network\Structure\NetworkAddress;
use BitWasp\Bitcoin\Parser;

class Version extends NetworkSerializable
{
    /**
     * @var int|string
     */
    protected $version;

    /**
     * @var int|string
     */
    protected $services;

    /**
     * @var int|string
     */
    protected $timestamp;

    /**
     * @var NetworkAddress
     */
    protected $addrRecv;

    /**
     * @var NetworkAddress
     */
    protected $addrFrom;

    /**
     * @var Buffer
     */
    protected $userAgent;

    /**
     * @var int|string
     */
    protected $startHeight;

    /**
     * @var bool
     */
    protected $relay;

    /**
     * @var Buffer
     */
    protected $nonce;

    /**
     * @param $version
     * @param Buffer $services
     * @param $timestamp
     * @param NetworkAddress $addrRecv
     * @param NetworkAddress $addrFrom
     * @param $userAgent
     * @param $startHeight
     * @param $relay
     */
    public function __construct(
        $version,
        Buffer $services,
        $timestamp,
        NetworkAddress $addrRecv,
        NetworkAddress $addrFrom,
        $userAgent,
        $startHeight,
        $relay
    ) {
        $random = new Random();
        $this->nonce = $random->bytes(8)->getInt();
        $this->version = $version;
        $this->services = $services->getInt();
        $this->timestamp = $timestamp;
        $this->addrRecv = $addrRecv;
        $this->addrFrom = $addrFrom;
        $this->userAgent = $userAgent;
        $this->startHeight = $startHeight;
        $this->relay = $relay;
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Bitcoin\Network\NetworkSerializableInterface::getNetworkCommand()
     */
    public function getNetworkCommand()
    {
        return 'version';
    }

    /**
     * @return VerAck
     */
    public function reply()
    {
        return new VerAck();
    }

    /**
     * @return Buffer
     */
    public function getBuffer()
    {
        $bytes = new Parser();
        $bytes
            ->writeInt(4, $this->version, true)
            ->writeInt(8, $this->services, true)
            ->writeInt(8, $this->timestamp, true)
            ->writeBytes(26, $this->addrRecv)
            ->writeBytes(26, $this->addrFrom)
            ->writeInt(8, $this->nonce, true)
            ->writeWithLength($this->userAgent)
            ->writeInt(4, $this->startHeight, true)
            ->writeInt(1, $this->relay);

        return $bytes->getBuffer();
    }
}
