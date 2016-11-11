<?php

use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext
{
    /**
     * @When I am on the pomm profiler
     */
    public function iAmOnThePommProfiler()
    {
        $this->visitPath('/index.php/_profiler/latest?panel=pomm');
    }

    /**
     * @When I am on the timeline
     */
    public function iAmOnTheTimeline()
    {
        $this->visitPath('/index.php/_profiler/latest?panel=time');
    }

    /**
     * @Then I should see the debug toolbar
     */
    public function debugToolbar()
    {
        $this->assertElementOnPage('.sf-toolbar');
    }
}
