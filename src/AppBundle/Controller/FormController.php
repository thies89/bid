<?php

namespace Strassen\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Strassen\AppBundle\Entity\Marker;
use Strassen\AppBundle\Form\AddType;

class FormController extends Controller
{
    /**
     * @Route("/mitmachen", name="add")
     */
    public function addAction(Request $request)
    {
        $marker = new Marker();
        $form = $this->createForm(new AddType(), $marker);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // add error handling (try catch) here
            $geocoderResult = $this->get('bazinga_geocoder.geocoder')
                ->using('google_maps')
                ->geocode($marker->getAddress() . ' Hamburg')
            ;

            // update marker with geocoded data
            $marker
                ->setAddress(sprintf(
                    '%s %s, %d %s (%s)',
                    $geocoderResult->getStreetName(),
                    $geocoderResult->getStreetNumber(),
                    $geocoderResult->getZipcode(),
                    $geocoderResult->getCity(),
                    $geocoderResult->getCityDistrict()
                ))
                ->setLat($geocoderResult->getLatitude())
                ->setLng($geocoderResult->getLongitude())
            ;

            $em->persist($marker);
            $em->flush();

            return $this->render('form/success.html.twig');
        }

        return $this->render('form/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
