<?php

namespace Soloist\Bundle\CoreBundle\Tests\Block;

use Soloist\Bundle\CoreBundle\Block\Factory;
use Symfony\Component\Yaml\Yaml;

/**
 *
 */
class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     *
     */
    public function setUp()
    {
        $this->factory = new Factory(self::getPageConfig(), self::getBlockConfig());
    }

    /**
     *
     */
    public function testGetPageFirst()
    {
        $this->assertSame('chapo_et_paragraphes_avec_image_alternes', $this->factory->getPageFirst());
    }

    /**
     *
     */
    public function testGetPagePageType()
    {
        $this->assertSame(array(), $this->factory->getPageType('unexistant'));
        $this->assertSame(6, count($this->factory->getPageType('chapo_et_paragraphes_avec_image_alternes')));
        $this->assertSame(7, count($this->factory->getPageType('chapo_et_paragraphes_avec_image_en_bas')));
    }

    /**
     *
     */
    public function testGetPageTemplate()
    {
        $this->assertSame('::lead_alternate_text_image.html.twig', $this->factory->getPageTemplate('chapo_et_paragraphes_avec_image_alternes'));
        $this->assertSame('::lead_text_image.html.twig', $this->factory->getPageTemplate('chapo_et_paragraphes_avec_image_en_bas'));
    }

    /**
     *
     */
    public function testGetPageFormTemplate()
    {
        $this->assertSame('::admin_lead_alternate_text_image.html.twig', $this->factory->getPageFormTemplate('chapo_et_paragraphes_avec_image_alternes'));
        $this->assertSame('::admin_lead_text_image.html.twig', $this->factory->getPageFormTemplate('chapo_et_paragraphes_avec_image_en_bas'));
    }

    /**
     *
     */
    public function testGetPageTypes()
    {
        $this->assertSame(2, count($this->factory->getPageTypes()));
        $this->assertArrayHasKey('chapo_et_paragraphes_avec_image_alternes', $this->factory->getPageTypes());
        $this->assertArrayHasKey('chapo_et_paragraphes_avec_image_en_bas', $this->factory->getPageTypes());
    }

    /**
     *
     */
    public function testCreateBlock()
    {
        $this->assertInstanceOf('Soloist\\Bundle\\CoreBundle\\Entity\\TextBlock', $this->factory->createBlock('text'));
        $this->assertInstanceOf('Soloist\\Bundle\\CoreBundle\\Entity\\ImageBlock', $this->factory->createBlock('image'));
    }

    /**
     *
     */
    public function testGetBlockTemplate()
    {
        $this->assertSame(':Form:block_text.html.twig', $this->factory->getBlockTemplate('text'));
        $this->assertSame(':Form:block_image.html.twig', $this->factory->getBlockTemplate('image'));
    }

    /**
     *
     */
    public function testGetBlockForm()
    {
        $this->assertInstanceOf('Soloist\Bundle\CoreBundle\Form\Type\TextBlockType', $this->factory->getBlockForm('text'));
        $this->assertInstanceOf('Soloist\Bundle\CoreBundle\Form\Type\ImageBlockType', $this->factory->getBlockForm('image'));
    }

    private static function getConfig($type)
    {
        static $config = null;

        if (null === $config) {
            $config = Yaml::parse(file_get_contents(__DIR__.'/../stubs/soloist.yml'));
        }

        return $config['soloist_core'][$type];
    }

    /**
     * @static
     * @return array
     */
    private static function getPageConfig()
    {
        return self::getConfig('page_types');
    }

    /**
     * @static
     * @return array
     */
    private static function getBlockConfig()
    {
        return self::getConfig('block_types');
    }
}
