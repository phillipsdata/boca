<?php
namespace PhillipsData\Boca\tests\unit;

use PHPUnit_Framework_TestCase;
use PhillipsData\Boca\Transport;

/**
 * @coversDefaultClass \PhillipsData\Boca\Transport
 */
class TransportTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::send
     * @covers ::receive
     * @covers ::__construct
     */
    public function testSend()
    {

        $input = "<MAC>\n\n";
        $output = "MAC Address: 00:0D:00:00:01";

        $socketMock = $this->getSocketMock();
        $socketMock->method('selectRead')
            ->will($this->onConsecutiveCalls(false, true, true, true, false));
        $socketMock->method('read')
            ->will($this->onConsecutiveCalls(substr($output, 0, 16), substr($output, 16)));

        $mockConnection = $this->getMockConnection();
        $mockConnection->method('getSocket')
            ->will($this->onConsecutiveCalls($socketMock));

        $transport = new Transport($mockConnection);

        $this->assertEquals($output, $transport->send($input));
    }

    private function getSocketMock()
    {
        return $this->getMockBuilder('\Socket\Raw\Socket')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function getMockConnection()
    {
        return $this->getMockBuilder('\PhillipsData\Boca\Connection')
            ->disableOriginalConstructor()
            ->getMock();
    }
}
