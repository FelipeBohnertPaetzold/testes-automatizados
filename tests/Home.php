<?php

namespace Tests;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;

class Home extends SigninTest
{

    protected $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return Home
     */
    public function clickSignin()
    {
        $this->driver->findElement(WebDriverBy::linkText('Sign in'))->click();
        return $this;
    }

    /**
     * @return Home
     */
    public function fillUsername($username)
    {
        $this->driver->findElement(WebDriverBy::cssSelector('#signinbox input[name="login"]'))
            ->sendKeys($username);
        return $this;
    }

    /**
     * @return Home
     */
    public function fillPassword($password)
    {
        $this->driver->findElement(WebDriverBy::cssSelector('#signinbox input[name="password"]'))
            ->sendKeys($password);
        return $this;
    }

    /**
     * @return Home
     */
    public function submit()
    {
        $this->driver->findElement(WebDriverBy::cssSelector('#signinbox a'))->click();
        return $this;
    }

    public function login($username, $password)
    {
        return $this->clickSignin()
            ->fillUsername($username)
            ->fillPassword($password)
            ->submit();
    }

    /**
     * @return AboutMe
     */
    public function gotToAboutMe()
    {
        $this->driver->findElement(WebDriverBy::className('me'))->click();
        return new AboutMe($this->driver);
    }

}