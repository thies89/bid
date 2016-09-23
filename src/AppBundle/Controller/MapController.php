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
                'business' => array(
                  'name'   => $singleMarker->getLabel(),
                  'address' => $singleMarker->getAddress(),
                  'addressInfo' => $singleMarker->getAddressInfo(),
                ),
                'usage' => array(
                    'name'  => $singleMarker->getUsage()->getName(),
                    'color' => $singleMarker->getUsage()->getColor(),


                ),
            );
        } , $marker);

        return new JsonResponse($marker);
    }
}
