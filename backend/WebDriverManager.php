<?php
require 'vendor/autoload.php';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class WebDriverManager {
    private static $instance = null;
    private $driver = null;
    private $lastUsed = null;
    private $sessionTimeout = 300;
    
    private function __construct() {
        $this->initDriver();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function initDriver() {
        $host = 'http://selenium:4444/wd/hub';
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability('goog:chromeOptions', [
            'args' => [
                '--headless=new',
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--window-size=1920,1080'
            ]
        ]);
        
        $this->driver = RemoteWebDriver::create($host, $capabilities, 15000, 30000);
        $this->lastUsed = time();
    }
    
    public function getDriver() {
        if ($this->driver === null || !$this->isSessionActive()) {
            $this->restartDriver();
        }
        
        $this->lastUsed = time();
        return $this->driver;
    }
    
    private function isSessionActive() {
        try {
            $this->driver->getCurrentUrl();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    private function restartDriver() {
        if ($this->driver !== null) {
            try {
                $this->driver->quit();
            } catch (Exception $e) {
            }
        }
        $this->initDriver();
    }
    
    public function cleanup() {
        if ($this->driver !== null) {
            $this->driver->quit();
            $this->driver = null;
        }
    }
    
    public function checkTimeout() {
        if ($this->lastUsed && (time() - $this->lastUsed) > $this->sessionTimeout) {
            $this->restartDriver();
        }
    }
}

register_shutdown_function(function() {
    if (WebDriverManager::getInstance()) {
        WebDriverManager::getInstance()->cleanup();
    }
});