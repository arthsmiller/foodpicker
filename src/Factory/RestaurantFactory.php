<?php

namespace App\Factory;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Restaurant>
 *
 * @method        Restaurant|Proxy                     create(array|callable $attributes = [])
 * @method static Restaurant|Proxy                     createOne(array $attributes = [])
 * @method static Restaurant|Proxy                     find(object|array|mixed $criteria)
 * @method static Restaurant|Proxy                     findOrCreate(array $attributes)
 * @method static Restaurant|Proxy                     first(string $sortedField = 'id')
 * @method static Restaurant|Proxy                     last(string $sortedField = 'id')
 * @method static Restaurant|Proxy                     random(array $attributes = [])
 * @method static Restaurant|Proxy                     randomOrCreate(array $attributes = [])
 * @method static RestaurantRepository|RepositoryProxy repository()
 * @method static Restaurant[]|Proxy[]                 all()
 * @method static Restaurant[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Restaurant[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Restaurant[]|Proxy[]                 findBy(array $attributes)
 * @method static Restaurant[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Restaurant[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class RestaurantFactory extends ModelFactory
{
    private const RANDOM_PHOT_PATH = [
        'assets/img/restaurants/logo_hakis.png'
    ];
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     */
    protected function getDefaults(): array
    {
        return [
            'background_url' => self::faker()->randomElement(self::RANDOM_PHOT_PATH),
            'logoFile' => self::faker()->imageUrl(),
            'logoUrl' => self::faker()->randomElement(self::RANDOM_PHOT_PATH),
            'name' => self::faker()->text(),
            'shopUrl' => self::faker()->url(),
            'categories' => [self::faker()->name(), self::faker()->name()],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Restaurant $restaurant): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Restaurant::class;
    }
}
