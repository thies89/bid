<?php

namespace Strassen\AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use Strassen\AppBundle\Util\PrivacyProtector;

class MapController extends Controller
{
    /**
     * @Route("/", name="map")
     */
    public function mapAction()
    {
        return $this->render('map/map.html.twig');
    }

    /**
     * @Route("/marker", name="marker")
     */
    public function markerAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Business')
        ;

        $marker = $repository->findAll();

        $marker = array_map(function($singleMarker) {
            return array(
                'lat'      => $singleMarker->getLat(),
                'lng'      => $singleMarker->getLng(),
                'usage' => array(
                    'name'  => PrivacyProtector::obfuscateName($singleMarker->getUsage()->getName()),
                    'color' => PrivacyProtector::obfuscateColor($singleMarker->getUsage()->getColor()),
                ),
            );
        } , $marker);

        return new JsonResponse($marker);
    }
}
