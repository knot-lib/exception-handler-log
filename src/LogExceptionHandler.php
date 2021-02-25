<?php
declare(strict_types=1);

namespace KnotLib\ExceptionHandler\Log;

use Throwable;

use Psr\Log\LoggerInterface;

use Stk2k\File\File;
use KnotLib\ExceptionHandler\ExceptionHandlerInterface;
use KnotLib\ExceptionHandler\DebugtraceRendererInterface;

class LogExceptionHandler implements ExceptionHandlerInterface
{
    /** @var LoggerInterface */
    private $logger;
    
    /** @var File */
    private $renderer;
    
    /**
     * Charcoal_ConsoleExceptionHandler constructor.
     *
     * @param LoggerInterface $logger
     * @param DebugtraceRendererInterface $renderer
     */
    public function __construct(LoggerInterface $logger, DebugtraceRendererInterface $renderer)
    {
        $this->logger = $logger;
        $this->renderer = $renderer;
    }
    
    /**
     * execute exception handlers
     *
     * @param Throwable $e     exception to handle
     */
    public function handleException(Throwable $e) : void
    {
        // Render exception
        $output = $this->renderer->output($e);
        
        // output
        $this->logger->error($output, [
            'exception' => $e,
        ]);
    }

}

