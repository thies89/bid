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


        $markers = array_map(function($marker) {
            $serialized = array(
                'id'       => $marker->getId(),
                'lat'      => $marker->getLat(),
                'lng'      => $marker->getLng(),
                'business' => array(
                  'name'          => $marker->getLabel(),
                  'address'       => $marker->getAddress(),
                  'addressInfo'   => $marker->getAddressInfo(),
                  'inhabited'     => boolval($marker->getInhabited()),
                  'more_industry' => boolval($marker->getMoreIndustry()),
                  'branded'       => boolval($marker->getBranded()),
                  'to_go'         => boolval($marker->getToGo()),
                ),
                'usage' => array(
                    'id'     => $marker->getUsage()->getId(),
                    'name'   => $marker->getUsage()->getName(),
                    'color'  => $marker->getUsage()->getColor(),
                ),
            );

            if ($outdoorArea = $marker->getOutdoorArea()) {
              $serialized['business']['outdoor_area'] = array(
                'id'              => $outdoorArea->getId(),
                'seats'           => intval($outdoorArea->getSeats()),
                'bartable_places' => intval($outdoorArea->getBarPlaces()),
                'roof'            => boolval($outdoorArea->getRoof()),
                'railings'        => boolval($outdoorArea->getRailings()),
              );
            } else {
              $serialized['business']['outdoor_area'] = false;
            }


            if ($parentUsage = $marker->getUsage()->getParent()) {
              $serialized['usage']['parent'] = array(
                'id'    => $parentUsage->getId(),
                'name'  => $parentUsage->getName(),
                'color' => $parentUsage->getColor(),
              );
            }


            return $serialized;
        }, $repository->findAll());


        return new JsonResponse($markers);
    }
}
