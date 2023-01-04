<?php

namespace App\Form;

use App\DTO\NotificationFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('notificationId', ChoiceType::class, [
                'choices' => NotificationFormData::NOTIFICATIONS,
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-control', 'rows' => 5]
            ])
            ->add('sendBtn', SubmitType::class, ['label' => 'Send'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NotificationFormData::class,
        ]);
    }
}
