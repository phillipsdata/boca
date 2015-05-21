<?php
namespace PhillipsData\Boca;

/**
 * Boca Transport
 */
class Transport
{
    private $socket;

    /**
     * Initialize the transport
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->socket = $connection->getSocket();
    }

    /**
     * Send the given request to the connected socket
     *
     * @param string $str The request
     * @return string The response
     */
    public function send($str)
    {
        $this->socket->write($str);

        return $this->receive();
    }

    /**
     * Wait for a response from the socket
     *
     * @return string The response
     */
    private function receive()
    {
        $bufferSize = 2048;
        $response = null;

        while (true) {
            if (!$this->socket->selectRead()) {
                continue;
            }

            $read = $this->socket->read($bufferSize);
            $response .= $read;

            if (!$this->socket->selectRead()) {
                break;
            }

        }
        return $response;
    }
}
