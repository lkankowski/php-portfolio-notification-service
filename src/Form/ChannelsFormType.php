<?php

namespace App\Form;

use App\MessagingProvider\NotificationServiceInterface;
use App\MessagingProvider\ProviderConfigItem;
use App\MessagingProvider\ProviderConfigTypeMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChannelsFormType extends AbstractType
{
    private const MANDATORY_FIELDS = [
        EmailType::class,
        TelType::class,
    ];

    /** @param NotificationServiceInterface[] $providersConfig */
    public function __construct(private readonly iterable $providersConfig)
    {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($this->getProvidersFields() as $field) {
            $type = ProviderConfigTypeMapper::mapToForm($field);
            $builder->add(
                $builder->create($field->id . '-group', FormType::class, [
                    'inherit_data' => true,
                    'label' => $field->description,
                    'attr' => ['class' => 'input-group input-group-text'],
                ])
                    ->add($field->id . '-enabled', CheckboxType::class, [
                        'label' => 'Enabled',
                        'required' => false,
                        'data' => isset($options['data'][$field->id . '-enabled']) ? $options['data'][$field->id . '-enabled'] : true,
                        'row_attr' => ['class' => 'form-check form-check-inline'],
                    ])
                    ->add($field->id . '-priority', IntegerType::class, [
                        'label' => 'Priority',
                        'data' => isset($options['data'][$field->id . '-priority']) ? $options['data'][$field->id . '-priority'] : $field->defaultPriority,
                        'attr' => ['style' => 'width: 100px'],
                    ])
                    ->add($field->id, $type, [
                        'label' => 'Value',
                        'required' => in_array($type, self::MANDATORY_FIELDS),
                    ])
            );
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

        /** @var NotificationServiceInterface $provider */
        foreach ($this->providersConfig as $provider) {
            foreach ($provider->getConfigFields() as $field) {
                $formFields[$field->id] = $field;
            }
        }

        return $formFields;
    }
}
