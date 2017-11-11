<?php

namespace Tests;
use Facebook\WebDriver\Remote\RemoteWebDriver,
    Facebook\WebDriver\Remote\DesiredCapabilities,
    Facebook\WebDriver\WebDriverBy,
    Facebook\WebDriver\WebDriverSelect,
    Facebook\WebDriver\WebDriverWait,
    Facebook\WebDriver\WebDriverExpectedCondition;
use Tests\Utils\Window;

class SigninTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Home
     */
    protected $home;

    /**
     * @var AboutMe
     */
    protected $aboutMe;

    /**
     * @var RemoteWebDriver
     */
    private $driver;


    public function setUp()
    {
        $this->driver = RemoteWebDriver::create("http://localhost:4444", DesiredCapabilities::chrome());
        $this->driver->manage()->window()->maximize();
        $this->driver->manage()->timeouts()->implicitlyWait(5);
        $this->driver->get('http://www.juliodelima.com.br/taskit');

        $this->home = new home($this->driver);
    }
    /**
     * @group ex5
     */
    public function testAddMoreDataAboutYou()
    {
        // Act
       $actual = $this->home->login('unicesumar', '123456')
            ->gotToAboutMe()
            ->deleteLast()
            ->getToastDelete();

        $expected = 'Rest in peace, dear phone!';
        $this->assertEquals($expected, $actual);
    }

    public function tearDown()
    {
        $this->driver->quit();
    }

}