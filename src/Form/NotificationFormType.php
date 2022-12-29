<?php

namespace App\Form;

use App\DTO\NotificationFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationFormType extends AbstractType
{
    public function __construct(private readonly array $emptyData)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phoneNumber', TelType::class)
            ->add('email', EmailType::class)
            ->add('pushyRecipient', TextType::class, [
                'label' => 'Pushy device token or topic',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'label_attr' => ['style' => 'vertical-align: top;'],
                'attr' => ['style' => 'width: 100%; height: 100px;']
            ])
            ->add('sendBtn', SubmitType::class, ['label' => 'Send'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NotificationFormData::class,
            'data' => new NotificationFormData(
                $this->emptyData['phoneNumber'],
                $this->emptyData['email'],
                $this->emptyData['pushyToken'],
                $this->emptyData['message'],
            ),
        ]);
    }
}
