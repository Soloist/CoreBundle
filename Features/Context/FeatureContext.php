<?php

namespace Soloist\Bundle\CoreBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Mink\Exception\ExpectationException,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext //MinkContext if you want to test web
{
    /**
     * @Given /^je suis sur une page du back-office$/
     */
    public function jeSuisSurUnePageDuBackOffice()
    {
        $this->visit('/admin');
    }

    /**
     * @Given /^je clique sur le bouton "([^"]*)" de la ligne contenant "([^"]*)"$/
     */
    public function jeCliqueSurLeBoutonDeLaLigneContenant($buttonLabel, $rowLabel)
    {
        foreach ($this->getSession()->getPage()->findAll('css', 'tr') as $element) {
            if ($element->has('named', array('content', $this->xpathLiteral($rowLabel)))) {
                $element->find('named', array('link', $this->xpathLiteral($buttonLabel)))->click();

                return;
            }
        }

        throw new ExpectationException(
            sprintf('Unable to find "%s" in row containing "%s"', $buttonLabel, $rowLabel),
            $this->getSession()
        );
    }

    private function xpathLiteral($locator)
    {
        return $this->getSession()->getSelectorsHandler()->xpathLiteral($locator);
    }
}
