<?php

namespace Strassen\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Strassen\AppBundle\Entity\Business;
use Strassen\AppBundle\Entity\Usage;
use Strassen\AppBundle\Entity\OutdoorArea;
use Strassen\AppBundle\Form\AddType;

use Ddeboer\DataImport\Reader\CsvReader;

class FormController extends Controller
{
    /**
     * @Route("/addContent", name="content")
     */
    public function createAction(Request $request)
    {
      /** @var \Doctrine\Common\Persistence\ObjectManager $em */
      $em = $this->getDoctrine()->getManager();

      if ($request->query->has('drop')) {
        $connection = $this->getDoctrine()->getConnection();
        $platform   = $connection->getDatabasePlatform();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');

        $truncateBusinessSql = $platform->getTruncateTableSQL('business');
        $truncateOutdoorAreaSql = $platform->getTruncateTableSQL('outdoorarea');
        $truncateUsageSql = $platform->getTruncateTableSQL('`usage`');
        $connection->executeUpdate($truncateBusinessSql);
        $connection->executeUpdate($truncateOutdoorAreaSql);
        $connection->executeUpdate($truncateUsageSql);

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');
      }

      // create parent categories
      $parentCategories = [
        'Bar',
        'Dienstleistung',
        'Einzelhandel',
        'Erotic',
        'Gastronomie',
        'Glücksspiel',
        'Kultur',
        'Nachtleben',
        'Sonstiges',
        'Tourismus',
        'Unterhaltung',
      ];

      foreach ($parentCategories as $category) {
        $variableName = strtolower($category);
        $variableName = str_replace('ü', 'ue', $variableName);

        $$variableName = new Usage;
        $$variableName->setName($category);

        $em->persist($$variableName);
      }

      $em->flush();

      $categories = [
        'Apotheke'  => $einzelhandel,
        'Außenbar' => $bar,
        'Bank' => $dienstleistung,
        'Bar' => $bar,
        'Bordel' => $erotic,
        'Burlesque Bar' => $bar,
        'Café' => $gastronomie,
        'Casino' => $gluecksspiel,
        'Club' => $nachtleben,
        'Dienstleistung' => $dienstleistung,
        'Diskothek' => $nachtleben,
        'Einzelhandel' => $einzelhandel,
        'Fast Food' => $gastronomie,
        'Galerie' => $kultur,
        'Garage' => $sonstiges,
        'Hotel' => $tourismus,
        'Irish Pub' => $bar,
        'Kiosk' => $einzelhandel,
        'Kirche' => $sonstiges,
        'Kneipe' => $bar,
        'Leerstand' => $sonstiges,
        'Leihhaus' => $dienstleistung,
        'Lounge' => $nachtleben,
        'Museum' => $kultur,
        'Polizeikommissariat' => $sonstiges,
        'Pub' => $bar,
        'Reise Center' => $tourismus,
        'Restaurant' => $gastronomie,
        'Sexshop' => $erotic,
        'Spielhalle' => $gluecksspiel,
        'Stripklub' => $erotic,
        'Supermarkt' => $einzelhandel,
        'Table Dance' => $erotic,
        'Tanzbar' => $bar,
        'Theater' => $unterhaltung,
        'Tourishop' => $tourismus,
        'Travestie' => $unterhaltung,
        'Unterhaltung' => $unterhaltung,
        'Veranstaltungsfläche' => $unterhaltung,
        'Wohnungen' => $sonstiges,
      ];


      // read data from csv
      $path = $this->getParameter('kernel.root_dir') . '/Resources/fixtures/';
      $file = new \SplFileObject($path.'final-import.csv');
      $reader = new CsvReader($file);

      $reader->setHeaderRowNumber(0);
      $created = 0;

      foreach ($reader as $row) {

          // prevent empty usage
          if (empty($row['usage'])) {
            continue;
          }

          // $row will now be an associative array:
          $business = new Business();
          $address = sprintf(
            '%s %s',
            $row['address'],
            $row['number']
          );

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

            if (array_key_exists($row['usage'], $categories)) {
              $parent = $categories[$row['usage']];
              $usage->setParent($parent);
            }

            $em->persist($usage);
            $em->flush($usage);
          }
          $business->setUsage($usage);

          $business->setComment($row['comment']);
          $business->setPriceRange($row['priceRange']);
          $business->setToGo($row['toGo'] ? (boolean) $row['toGo'] : null);
          $business->setStartY($row['startY']);
          $business->setEndY($row['endY']);
          $business->setInhabited($row['inhabited'] ? (boolean) $row['inhabited'] : null);
          $business->setMoreIndustry($row['moreIndustry'] ? (boolean) $row['moreIndustry'] : null);

          $seats = $row['seats'];
          $barTable = $row['barTable'];
          $railings = $row['railings'] ? (boolean) $row['railings'] : null;
          $roof = $row['roof'] ? (boolean) $row['roof'] : null;

          if($seats || $barTable || $railings || $roof)
          {
            $outdoorArea = new OutdoorArea();
            $outdoorArea->setSeats($seats);
            $outdoorArea->setBarTable($barTable);
            $outdoorArea->setRailings($railings);
            $outdoorArea->setRoof($roof);

            $business->setOutdoorArea($outdoorArea);
            // $em->persist($outdoorArea);
          }

          $business->setBranded($row['branded'] ? (boolean) $row['branded'] : null);
          $business->setCreatedAt(new \DateTime($row['createdAt']));

          $em->persist($business);
          $created++;
      }

      $em->flush();


      return new Response('Imported ' . $created . ' businesses');
    }

    public function adjustBrightness($hex, $steps) {
      // Steps should be between -255 and 255. Negative = darker, positive = lighter
      $steps = max(-255, min(255, $steps));

      // Normalize into a six character long hex string
      $hex = str_replace('#', '', $hex);
      if (strlen($hex) == 3) {
          $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
      }

      // Split into three parts: R, G and B
      $color_parts = str_split($hex, 2);
      $return = '#';

      foreach ($color_parts as $color) {
          $color   = hexdec($color); // Convert to decimal
          $color   = max(0,min(255,$color + $steps)); // Adjust color
          $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
      }

      return $return;
    }

    /**
     * @Route("/changeColor", name="color")
     */
    public function changeAction(Request $request)
    {
      $bar = '#FFD700'; //gold
      $dienstleistung = '#696969'; //DimGray
      $einzelhandel = '#8B0000'; //DarkRed
      $erotic = '#FF1493'; //DeepPink
      $gastronomie = '#FF8C00'; //DarkOrange
      $gluecksspiel = '#000000'; //black
      $kultur = '#006400'; //DarkGreen
      $nachtleben = '#00008B'; //DarkBlue
      $sonstiges = '#D3D3D3'; //LightGray
      $tourismus = '#F5F5F5'; //WhiteSmoke
      $unterhaltung = '#32CD32'; //LimeGreen

      $colors = [
        //Bar adjustBrightness($bar, 255 - rand(0, 510)),
        'Bar' => $bar,
        'Außenbar' => $bar,
        'Burlesque Bar' => $bar,
        'Irish Pub' => $bar,
        'Kneipe' => $bar,
        'Pub' => $bar,
        'Tanzbar' => $bar,

        //Dienstleistung
        'Dienstleistung' => $dienstleistung,
        'Bank' => $dienstleistung,
        'Leihhaus' => $dienstleistung,

        //Einzelhandel
        'Einzelhandel' => $einzelhandel,
        'Apotheke'  => $einzelhandel,
        'Kiosk' => $einzelhandel,
        'Supermarkt' => $einzelhandel,

        //Erotic
        'Erotic' => $erotic,
        'Bordel' => $erotic,
        'Sexshop' => $erotic, //zu Einzelhandel?
        'Stripklub' => $erotic,
        'Table Dance' => $erotic,

        //Gastronomie
        'Gastronomie' => $gastronomie,
        'Café' => $gastronomie,
        'Fast Food' => $gastronomie,
        'Restaurant' => $gastronomie,

        //Gluecksspiel
        'Gluecksspiel' => $gluecksspiel,
        'Casino' => $gluecksspiel,
        'Spielhalle' => $gluecksspiel,

        //Kultur
        'Kultur' => $kultur,
        'Galerie' => $kultur,
        'Museum' => $kultur,

        //Nachtleben
        'Nachtleben' => $nachtleben,
        'Club' => $nachtleben,
        'Diskothek' => $nachtleben,
        'Lounge' => $nachtleben,

        //Sonstiges
        'Sonstiges' => $sonstiges,
        'Garage' => $sonstiges,
        'Kirche' => $sonstiges,
        'Leerstand' => $sonstiges,
        'Polizeikommissariat' => $sonstiges,
        'Wohnungen' => $sonstiges,

        //Tourismus
        'Tourismus' => $tourismus,
        'Hotel' => $tourismus,
        'Reise Center' => $tourismus,
        'Tourishop' => $tourismus, //zu Einzelhandel?

        //Unterhaltung
        'Unterhaltung' => $unterhaltung,
        'Theater' => $unterhaltung, //zu Kultur?
        'Travestie' => $unterhaltung,
        'Veranstaltungsfläche' => $unterhaltung,

      ];

      $em = $this->getDoctrine()->getManager();

      foreach ($colors as $name => $color) {
        $usage = $em->getRepository('AppBundle:Usage')->findOneBy(['name' => $name]);
        if($usage) {
          $usage->setColor($color);
        }
      }

      $em->flush();

      return new Response('Updated colors');
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
