<?php

namespace Tests\Utils;

use Facebook\WebDriver\Remote\RemoteWebDriver;

abstract class Window
{
    public static function takeScreenshot(RemoteWebDriver $driver)
    {
        $driver->executeScript('window.scroll(0, 0)');
        $driver->takeScreenshot('evidences/screebshot.jpg');
    }
}