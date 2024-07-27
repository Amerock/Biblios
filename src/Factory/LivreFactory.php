<?php

namespace App\Factory;

use App\Entity\Livre;
use App\Enum\StatusLivre;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Livre>
 */
final class LivreFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Livre::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'couverture' => self::faker()->imageUrl(330, 500, 'couverture', true),
            'DateEdition' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'isbn' => self::faker()->isbn13(),
            'nbpages' => self::faker()->randomNumber(),
            'resume' => self::faker()->text(),
            'status' => self::faker()->randomElement(StatusLivre::cases()),
            'Titre' => self::faker()->unique()->sentence(),
            'editeur' => EditeurFactory::random(),
            'auteur' => AuteurFactory::randomSet(self::faker()->numberBetween(1, 2)),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Livre $livre): void {})
        ;
    }
}
