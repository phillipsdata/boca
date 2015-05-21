<?php
namespace PhillipsData\Boca\tests\unit;

use PHPUnit_Framework_TestCase;
use PhillipsData\Boca\Connection;

/**
 * @coversDefaultClass \PhillipsData\Boca\Connection
 */
class ConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::close
     * @covers ::__construct
     * @covers ::open
     */
    public function testClose()
    {
        $socketMock = $this->getSocketMock();
        $socketMock->expects($this->once())
            ->method('close');

        $factoryMock = $this->getFactoryMock();
        $factoryMock->method('createClient')
            ->will($this->returnValue($socketMock));

        $connection = new Connection('tcp:127.0.0.1:9100', $factoryMock);
        $connection->open();
        $connection->close();
    }

    /**
     * @covers ::getSocket
     * @covers ::__construct
     * @covers ::open
     */
    public function testGetSocket()
    {
        $factoryMock = $this->getFactoryMock();
        $factoryMock->method('createClient')
            ->will($this->returnValue($this->getSocketMock()));

        $connection = new Connection('tcp:127.0.0.1:9100', $factoryMock);
        $connection->open();
        $this->assertInstanceOf('\Socket\Raw\Socket', $connection->getSocket());
    }

    private function getFactoryMock()
    {
        return $this->getMockBuilder('\Socket\Raw\Factory')
            ->getMock();
    }

    private function getSocketMock()
    {
        return $this->getMockBuilder('\Socket\Raw\Socket')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
