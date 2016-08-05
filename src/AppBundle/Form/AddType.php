<?php

namespace Strassen\AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', 'text', array(
                'label' => 'Adresse',
                'attr'  => array(
                    'placeholder' => 'Straße und Hausnummer',
                ),
            ))
            ->add('addressInfo', 'text', array(
                'label' => 'Adresszusatz',
                'attr'  => array(
                    'placeholder' => 'Etage, Hinterhof oder ähnliches',
                ),
            ))
            ->add('category', 'entity', array(
                'label'        => 'Eigentümer_in',
                'class'        => 'AppBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.name NOT LIKE :saga')
                        ->andWhere('c.name NOT LIKE :wohnprojekt')
                        ->setParameters(array(
                            'saga'        => 'SAGA-GWG',
                            'wohnprojekt' => 'Wohnprojekt',
                        ))
                        ->orderBy('c.weight', 'ASC')
                    ;
                },
                'choice_label' => 'name'
            ))
            ->add('usageType', 'choice', array(
                'label'    => 'Nutzungsart',
                'choices'  => array(1 => 'Wohnung', 2 => 'Gewerbe'),
                'expanded' => true,
            ))

            ->add('contact', 'email', array(
                'label' => 'Kontakt',
                'attr'  => array(
                    'placeholder' => 'Mailadresse',
                ),
                'required' => false,
            ))
            ->add('contactUse', 'choice', array(
                'label'    => 'Wir dürfen die Mailadresse nutzen für',
                'choices'  => array(1 => 'Rückfragen', 2 => 'Newsletter'),
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ))
            ->add('own', 'choice', array(
                'label'    => 'In der genannten Wohnung bin ich',
                'choices'  => array(1 => 'Mieter_in', 2 => 'Vermieter_in', 3 => 'Eigentümer_in', 4 => 'Besetzer_in', 5 => 'Nichts von alle dem', null => 'keine Angabe'),
                'required' => false,
            ))
            ->add('source', 'choice', array(
                'label'    => 'Die Infos habe ich von',
                'choices'  => array(1 => 'Mieter_in', 2 => 'Vermieter_in', 3 => 'Freund_in, Bekannt_e usw.', 4 => 'Recherche', 5 => 'Sonstiges', null => 'keine Angabe'),
                'required' => false,
            ))
            ->add('startY', 'integer', array(
                'label'    => 'Angabe gilt seit',
                'attr'     => array(
                    'placeholder' => '2000'
                ),
                'required' => false,
            ))
            ->add('endY', 'integer', array(
                'label' => 'bis Jahr',
                'attr' => array(
                    'placeholder' => date('Y')
                ),
                'required' => false,
            ))
            ->add('flatAttr', 'choice', array(
                'label'    => 'Eigenschaften',
                'choices'  => array(1 => 'Sozialwohnung', 2 => 'Staffelmiete', 3 => 'temporäre Ferienwohnung', 4 => 'dauerhafte Ferienwohnung', 5 => 'Wohnprojekt'),
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ))
            ->add('numberFlat', 'integer', array(
                'label'    => 'Anzahl der Wohnungen im Haus',
                'required' => false,
            ))
            ->add('numberInd', 'integer', array(
                'label'    => 'Anzahl der Gewerbeeinheiten im Haus',
                'required' => false,
            ))
            ->add('price', 'integer', array(
                'label'    => 'Gesamte Kaltmiete',
                'required' => false,
            ))
            ->add('size', 'integer', array(
                'label' => 'Größe',
                'required' => false,
            ))
            ->add('comment', 'textarea', array(
                'label'    => 'Anmerkungen',
                'attr'     => array('rows' => '5'),
                'required' => false,
            ))

            ->add('privacy', 'checkbox', array(
                'label'  => 'Ich akzeptiere die Datenschutzbedingungen und willige ein, dass die Daten anonymisiert veröffentlicht werden.',
                'mapped' => false,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Strassen\AppBundle\Entity\Marker',
            'cascade_validation' => true,
        ));
    }

    public function getName()
    {
        return 'add';
    }
}
