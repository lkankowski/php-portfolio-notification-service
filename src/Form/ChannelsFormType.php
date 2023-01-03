<?php

namespace App\Form;

use App\DTO\NotificationFormData;
use App\MessagingProvider\ProviderConfigItem;
use App\MessagingProvider\ProviderConfigurationInterface;
use App\MessagingProvider\ProviderConfigTypeMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChannelsFormType extends AbstractType
{
    private const MANDATORY_FIELDS = [
        EmailType::class,
        TelType::class,
    ];

    /** @param ProviderConfigurationInterface[] $providersConfig */
    public function __construct(private readonly iterable $providersConfig)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($this->getProvidersFields() as $type => $field) {
            $builder->add($field->id, $type, [
                'label' => $field->description,
                'required' => in_array($type, self::MANDATORY_FIELDS),
            ]);
        }

        $builder
            ->add('save-btn', SubmitType::class, ['label' => 'Save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }

    /** @return array<class-string, ProviderConfigItem> */
    private function getProvidersFields(): array
    {
        $formFields = [];

        /** @var ProviderConfigurationInterface $provider */
        foreach ($this->providersConfig as $provider) {
            foreach ($provider->getConfigFields() as $field) {
                $formFields[ProviderConfigTypeMapper::mapToForm($field)] = $field;
            }
        }

        return $formFields;
    }
}
