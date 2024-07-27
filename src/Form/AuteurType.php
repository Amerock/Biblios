<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Livre;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
 public function buildForm(FormBuilderInterface $builder, array $options): void
 {
    $builder
    ->add('name', TextType::class, [
        'label' => 'Nom',
    ])
 ->add('dateOfBirth', null, [
'widget' => 'single_text',
'label' => 'Date de naissance',

])
 ->add('dateOfDeath', null, [
'widget' => 'single_text',
 'required' => false,
 'label' => 'Date de décès',
 ])
->add('nationality', TextType::class, [
'required' => false,
'label' => 'Nationalité',
 ])
 ->add('livres', EntityType::class, [
 'class' => Livre::class,
 'choice_label' => 'id',
'multiple' => true,
 'required' => false,
 ])
 ;
 }

 public function configureOptions(OptionsResolver $resolver): void
 {
 $resolver->setDefaults([
'data_class' => Auteur::class,
 ]);
 }
}
