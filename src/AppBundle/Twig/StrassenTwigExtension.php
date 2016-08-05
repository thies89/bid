<?php

namespace Strassen\AppBundle\Twig;

use Doctrine\ORM\EntityManager;

use Strassen\AppBundle\Util\PrivacyProtector;

class StrassenTwigExtension extends \Twig_Extension
{
    /** @var EntityManager  */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     *
     * @DI\InjectParams({
     *     "em" = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return array(
            'get_legend'   => new \Twig_Function_Method($this, 'getLegendItems'),
            'get_glossary' => new \Twig_Function_Method($this, 'getGlossaryItems'),
        );
    }

    public function getLegendItems()
    {
        $repository = $this->em->getRepository('AppBundle:Category');

        $items = $repository->findBy(array(), array('weight' => 'ASC'));

        $items = PrivacyProtector::filterCategories($items);

        $items = array_filter($items, function($item) {
            return count($item->getMarkers()) > 0;
        });


        return $items;
    }

    public function getGlossaryItems()
    {
        $repository = $this->em->getRepository('AppBundle:Category');

        return $repository->findBy(array(), array('weight' => 'ASC'));
    }

    public function getName()
    {
        return 'map_extension';
    }
}
