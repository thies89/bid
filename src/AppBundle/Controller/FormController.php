<?php

namespace Strassen\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Strassen\AppBundle\Entity\Business;
use Strassen\AppBundle\Entity\Usage;
use Strassen\AppBundle\Entity\OutdoorArea;
use Strassen\AppBundle\Form\AddType;

use Ddeboer\DataImport\Reader\CsvReader;

class FormController extends Controller
{
    /**
     * @Route("/addc", name="content")
     */
    public function createAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $path = $this->getParameter('kernel.root_dir') . '/Resources/fixtures/';
      $file = new \SplFileObject($path.'import5.csv');
      $reader = new CsvReader($file);

      $reader->setHeaderRowNumber(0);

      foreach ($reader as $row) {
          // dump($row);
          // continue;
          // $row will now be an associative array:
          $business = new Business();
          $address = sprintf(
            '%s %s',
            $row['address'],
            $row['number']
          );
          //dump($address);
          //die;
          // add error handling (try catch) here
          $geocoderResult = $this->get('bazinga_geocoder.geocoder')
              ->using('google_maps')
              ->geocode($address . ', Hamburg')
          ;

          // update marker with geocoded data
          $business
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

          $business->setAddressInfo($row['addressInfo']);
          $business->setLevels($row['levels']);
          $business->setLabel($row['label']);

          $usageRow = $row['usage'];
          // dump($usageRow);
          // $qb = $em->getRepository('AppBundle:Usage')->createQueryBuilder('u');
          // $usage = $qb->where($qb->expr()->like('u.name', '?1'))
          //   ->setParameter(1 , $row['usage'])
          //   ->getQuery()
          //   ->getOneOrNullResult();
          //   dump($usage);
          $usage = $em->getRepository('AppBundle:Usage')->findOneBy(['name' => $row['usage']]);
            // die;
          if(!$usage) {
            $usage = new Usage();
            $usage->setName($row['usage']);
            $em->persist($usage);
          }
          $business->setUsage($usage);

          $business->setComment($row['comment']);
          $business->setPriceRange($row['priceRange']);
          $business->setToGo($row['toGo']);
          $business->setStartY($row['startY']);
          $business->setEndY($row['endY']);
          $business->setInhabited($row['inhabited']);
          $business->setMoreIndustry($row['moreIndustry']);

          $seats = $row['seats'];
          $barTable = $row['barTable'];
          $railings = $row['railings'];
          $roof = $row['roof'];

          if($seats || $barTable || $railings || $roof)
          {
            $outdoorArea = new OutdoorArea();
            $outdoorArea->setSeats($seats);
            $outdoorArea->setBarTable($barTable);
            $outdoorArea->setRailings($railings);
            $outdoorArea->setRoof($roof);
            $em->persist($outdoorArea);
          }

          $business->setBranded($row['branded']);
          $business->setCreatedAt(new \DateTime($row['createdAt']));

          $em->persist($business);
      }
      $em->flush();
    }

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
                ->geocode($marker->getAddress() . ', Hamburg')
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
