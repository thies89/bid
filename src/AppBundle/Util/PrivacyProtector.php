<?php

namespace Strassen\AppBundle\Util;

use Doctrine\Common\Collections\ArrayCollection;

class PrivacyProtector
{
    public static function obfuscateName($name)
    {
        return ($name === 'SAGA-GWG') ? 'Stadt Hamburg' : $name;
    }

    public static function obfuscateColor($color)
    {
        return ($color === '#4CAF50') ? '#8BC34A' : $color;
    }

    public static function filterCategories(array $categories)
    {
        foreach ($categories as $category) {
            if ($category->getName() === 'Stadt Hamburg') {
                $staedtischesUnternehmen = $category;
            }
        }

        foreach ($categories as $category) {
            if ($category->getName() === 'SAGA-GWG') {
                $markers = $category->getMarkers();
                foreach ($markers as $marker) {
                    if (isset($staedtischesUnternehmen)) {
                        $staedtischesUnternehmen->addMarker($marker);
                    }
                }

                $category->setMarkers(new ArrayCollection());
            }
        }

        return $categories;
    }
}
