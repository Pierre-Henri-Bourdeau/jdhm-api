<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class ClientContext extends RawMinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When you visit :arg1
     */
    public function youVisit($arg1)
    {
        $session = $this->getSession();
        $result = $session->visit($this->locatePath($arg1));
        if ($session->getStatusCode() !== 200) {
            throw new \Exception(sprintf('Page %s returned %s', $arg1, $session->getStatusCode()));
        }
    }

    /**
     * @Then you should see :arg1
     */
    public function youShouldSee($arg1)
    {
        $session = $this->getSession();
        $content = $session->getPage()->getContent();

    }
}
