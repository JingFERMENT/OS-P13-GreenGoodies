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

        // This solves the issue by using "data => 0" to reset the dropdown 
        //  to 0, even if the user had previously selected another value
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function ($event) {
            $orderLine = $event->getData();
            if (!$orderLine) {
                return;
            }

            if ($orderLine->getQuantity() === null) {
                $orderLine->setQuantity(0);
            };
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderLine::class,
        ]);
    }
}
