<?php

namespace App\Form;

use App\Entity\OrderLine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartQuantityFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', ChoiceType::class, [
                'choices' => array_combine(range(0, 5), range(0, 5)), // symfony expects label => value
                'label' => 'Quantité',
                'required' => true,
                'attr' => ['class' => 'quantity-dropdown'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderLine::class,
        ]);
    }
}
