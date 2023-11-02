<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Facture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ClientToIdTransformer2 implements DataTransformerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transform($client)
    {
        return $client ? $client->getId() : null;
    }

    public function reverseTransform($clientId)
    {
        if (!$clientId) {
            return null;
        }

        $client = $this->entityManager
            ->getRepository(Clients::class)
            ->find($clientId);

        if (null === $client) {
            throw new TransformationFailedException(sprintf(
                'Un client avec l\'ID "%s" n\'existe pas!',
                $clientId
            ));
        }

        return $client;
    }
}

class StringToDateTimeTransformer2 implements DataTransformerInterface
{
    public function transform($dateTime)
    {
        if ($dateTime === null) {
            return '';
        }

        return $dateTime->format('Y-m-d');
    }

    public function reverseTransform($string)
    {
        return new \DateTime($string);
    }
}


class FactureType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texte', HiddenType::class, ['attr' => ['id' => 'facture_texte']])
            ->add('montantHorsTva', HiddenType::class, ['attr' => ['id' => 'facture_montantHorsTva']])
            ->add('TauxTva', HiddenType::class, ['attr' => ['id' => 'facture_TauxTva']])
            ->add('benefice', HiddenType::class, ['attr' => ['id' => 'facture_benefice']])
            ->add('accompte', HiddenType::class, ['attr' => ['id' => 'facture_accompte']])
            ->add('endDate', HiddenType::class, [
                'attr' => ['id' => 'facture_dateFin'],
                'empty_data' => new \DateTime(),
            ])
            ->add('client', HiddenType::class, ['attr' => ['id' => 'facture_client']])
        ;
        $builder->get('endDate')->addModelTransformer(new StringToDateTimeTransformer2());
        $builder->get('client')
            ->addModelTransformer(new ClientToIdTransformer2($this->entityManager));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
