<?php

declare(strict_types=1);

namespace App\Criteria\Form;

use App\Criteria\PostCriteria;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ttskch\PaginatorBundle\Form\CriteriaType;

class PostSearchType extends CriteriaType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('query', SearchType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Search for...',
                    'class' => 'w-100',
                ],
            ])
            ->add('after', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('before', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostCriteria::class,
        ]);
    }
}
