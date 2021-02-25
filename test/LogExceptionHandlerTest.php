<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Log\Test;

use KnotLib\ExceptionHandler\Log\LogExceptionHandler;
use KnotLib\ExceptionHandler\Text\TextDebugtraceRenderer;
use KnotLib\Kernel\Logger\EchoLogger;
use PHPUnit\Framework\TestCase;

final class LogExceptionHandlerTest extends TestCase
{
    public function testHandleException()
    {
        $logger = new EchoLogger();
        $renderer = new TextDebugtraceRenderer();
        $handler = new LogExceptionHandler($logger, $renderer);

        $e = new \Exception("test");

        ob_start();
        $handler->handleException($e);
        $output = ob_get_clean();

        $output = explode("\r\n", $output);

        $this->assertEquals("[E]=============================================================", $output[0]);
        $this->assertEquals("Exception stack trace", $output[1]);
        $this->assertEquals("=============================================================", $output[2]);
        $this->assertEquals("", $output[3]);
        $this->assertEquals("* Exception Stack *", $output[4]);
        $this->assertEquals("-------------------------------------------------------------", $output[5]);
        $this->assertEquals("[1]Exception", $output[6]);
        $this->assertEquals("   test", $output[8]);
    }
}