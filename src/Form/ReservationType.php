<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date de réservation',
                'widget' => 'single_text',
                'attr' => ['min' => (new \DateTime())->format('Y-m-d')]
            ])
            ->add('time', ChoiceType::class, [
                'label' => 'Créneau horaire',
                'choices' => [
                    '09:00' => '09:00',
                    '10:30' => '10:30',
                    '12:00' => '12:00',
                    '13:30' => '13:30',
                    '15:00' => '15:00',
                    '16:30' => '16:30',
                    '18:00' => '18:00',
                    '19:30' => '19:30'
                ]
            ])
            ->add('court', ChoiceType::class, [
                'label' => 'Terrain',
                'choices' => [
                    'Terrain 1' => 1,
                    'Terrain 2' => 2,
                    'Terrain 3' => 3
                ]
            ])
            ->add('players', IntegerType::class, [
                'label' => 'Nombre de joueurs',
                'attr' => [
                    'min' => 2,
                    'max' => 4
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
