<?php

namespace App\Form;

use App\Entity\MailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'mail_type.form.name',
                'translation_domain' => 'mail-type'
            ])
            ->add('displayOrder', NumberType::class, [
                'label' => 'mail_type.form.display_order',
                'translation_domain' => 'mail-type'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailType::class,
        ]);
    }
}
