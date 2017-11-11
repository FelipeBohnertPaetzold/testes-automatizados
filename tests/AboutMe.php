<?php
/**
 * Created by PhpStorm.
 * User: gustavoluizfernandes
 * Date: 11/11/17
 * Time: 14:00
 */

namespace Tests;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverWait;
use Tests\Utils\Window;


class AboutMe
{
    protected $driver;

    public function __construct(RemoteWebDriver $driver)
    {
        $this->driver = $driver;
    }

    public function deleteLast()
    {
        return $this->clickEditar()
        ->clickAddMoreData()
        ->selectField()
        ->fillPhone('999999')
        ->submit()
        ->waitTooltip()
        ->selectDelete()
        ->acceptDelete();
    }

    public function takeS()
    {

    }



    /**
     * @return AboutMe
     */
    public function clickEditar()
    {
        $this->driver->findElement(WebDriverBy::xpath("//a[@href = '#moredata']"))->click();
        return $this;
    }

    /**
     * @return AboutMe
     */
    public function clickAddMoreData()
    {
        $this->driver->findElement(WebDriverBy::xpath("//button[text() = '+ Add more data']"))->click();
        return $this;
    }

    /**
     * @return AboutMe
     */
    public function selectField()
    {
        $field_type = $this->driver->findElement(WebDriverBy::name('type'));
        $combo_type = new WebDriverSelect($field_type);
        $combo_type->selectByValue('phone');

        return $this;
    }

    /**
     * @return AboutMe
     */
    public function fillPhone($phone)
    {
        $this->driver->findElement(WebDriverBy::name('contact'))->sendKeys($phone);

        return $this;
    }

    /**
     * @return AboutMe
     */
    public function submit()
    {
        $this->driver->findElement(WebDriverBy::linkText('SAVE'))->click();

        return $this;
    }

    /**
     * @return AboutMe
     */
    public function waitTooltip()
    {
        $wait = new WebDriverWait($this->driver, 8, 1000);
        $wait->until(
            WebDriverExpectedCondition::invisibilityOfElementLocated(
                WebDriverBy::cssSelector('.toast.rounded')
            )
        );

        return $this;
    }
    /**
     * @return AboutMe
     */
    public function selectDelete()
    {
        $elements = $this->driver->findElement(WebDriverBy::id('moredata'))
            ->findElements(WebDriverBy::tagName('a'));
        $element = count($elements);
        $this->driver->findElement(WebDriverBy::xpath("//div[@id='moredata']/div/ul/li[$element]/a"))->click();
        return $this;
    }

    /**
     * @return AboutMe
     */
    public function acceptDelete()
    {
        $alerta = $this->driver->switchTo()->alert();
        $alerta->accept();
        return $this;
    }

    public function getToastDelete()
    {
        Window::takeScreenshot($this->driver);
        return $this->driver->findElement(WebDriverBy::cssSelector('.toast.rounded'))->getText();
    }

}