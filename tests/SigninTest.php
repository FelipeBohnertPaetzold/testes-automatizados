<?php

namespace Tests;
use Facebook\WebDriver\Remote\RemoteWebDriver,
    Facebook\WebDriver\Remote\DesiredCapabilities,
    Facebook\WebDriver\WebDriverBy,
    Facebook\WebDriver\WebDriverSelect,
    Facebook\WebDriver\WebDriverWait,
    Facebook\WebDriver\WebDriverExpectedCondition;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Window;

require "constantes.php";

class SigninTest extends TestCase
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

    private $sessionId;


    public function setUp()
    {
        $this->driver = RemoteWebDriver::create(
            BROWSERSTACK_URL,
            array("os"=>"Windows",
                "os_version"=>"7",
                "browserName"=>"Chrome",
                "resolution"=>"1280x800"
            )
        );
        $this->sessionId = $this->driver->getSessionID();
        $this->driver->manage()->window()->maximize();
//        $this->driver = RemoteWebDriver::create("http://localhost:4444", DesiredCapabilities::chrome());
        $this->driver->manage()->timeouts()->implicitlyWait(10);
        $this->driver->get('http://www.juliodelima.com.br/taskit');

        $this->home = new home($this->driver);
    }
    /**
     * @group ex5
     * @dataProvider dataProvider
     */
    public function testAddMoreDataAboutYou($username, $password)
    {
        // Act
       $actual = $this->home->login($username, $password)
            ->gotToAboutMe()
            ->deleteLast()
            ->getToastDelete();

        $expected = 'Rest in peace, dear phone!';
        $this->assertEquals($expected, $actual);
    }

    public function tearDown()
    {
        $name = $this->getName();
        $status = $this->getStatus();
        if ($status != 0) {
            file_get_contents(PUT_URL.$this->sessionId.'.json', false, stream_context_create(array('http'=>array('method'=>'PUT','header'=>'Content-type: application/json', 'content'=>'{"status":"failed","reason":"'.$name.'"}'))));
        }
        $this->driver->quit();
    }

    public static function dataProvider()
    {
        $json = file_get_contents('dataProviders/signInTest.json');
        $arr = json_decode($json, true);
        return $arr;
    }

}