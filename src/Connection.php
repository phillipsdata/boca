<?php
namespace PhillipsData\Boca;

use Socket\Raw\Factory;

/**
 * Boca Connection
 */
class Connection
{
    /**
     * @var \Socket\Raw\Socket The socket connection
     */
    private $socket;

    /**
     * @var string The address to connect to
     */
    private $address;

    /**
     *
     * @param type $address
     * @param Factory $factory
     */
    public function __construct($address, Factory $factory = null)
    {
        $this->address = $address;

        if (null === $factory) {
            $factory = new Factory();
        }

        $this->factory = $factory;
    }

    /**
     * Open a connection
     */
    public function open()
    {
        if (!$this->socket) {
            $this->socket = $this->factory->createClient($this->address);
        }
    }

    /**
     * Close the open connection
     */
    public function close()
    {
        if ($this->socket) {
            $this->socket->close();
            $this->socket = null;
        }
    }

    /**
     * Returns the open socket connection
     *
     * @return \Socket\Raw\Socket
     */
    public function getSocket()
    {
        return $this->socket;
    }
}
