<?php


class Openapi_Logger
{
    private static $instance;

    private $errorFile;

    private $infoFile;

    private $log = array('file' => '', 'line' => '');

    private $dir;
    private $date;

    private function __construct()
    {
        $this->date = date('Y-m-d');
        $this->dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;
        $this->errorFile = $this->dir . $this->date . '-error.log';
        $this->infoFile = $this->dir . $this->date . '-info.log';
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function error($txt)
    {
        $this->writeLog($this->errorFile, $this->getLogText($txt));
    }

    public function info($txt)
    {
        $this->writeLog($this->infoFile, $this->getLogText($txt));
    }

    private function writeLog($fileName, $txt)
    {
        $fp = @fopen($fileName, 'a');
        @flock($fp, LOCK_EX);
        @fwrite($fp, $txt);
        @flock($fp, LOCK_UN);
        @fclose($fp);
    }

    private function getLogText($txt)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $this->log = isset($trace[2]) ? $trace[2] : (isset($trace[1]) ? $trace[1] : array('file' => '', 'line' => ''));
        $this->log['file'] = str_replace(dirname(dirname(__FILE__)), '', $this->log['file']);
        return date('Y-m-d H:i:s') . '##' . $_SERVER['REQUEST_URI'] . '##' . $this->log['file'] . ':' . $this->log['line'] . '##' . $txt . "\r\n";
    }

}