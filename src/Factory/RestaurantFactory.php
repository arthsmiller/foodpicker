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
    private const BACKGROUND_PHOTOS = [
        'assets/img/restaurants/backgrounds/2_brueder.jpg',
        'assets/img/restaurants/backgrounds/amore.jpg',
        'assets/img/restaurants/backgrounds/asia_china_imbiss.jpg',
        'assets/img/restaurants/backgrounds/asia_thai.jpg',
        'assets/img/restaurants/backgrounds/athos.jpg',
        'assets/img/restaurants/backgrounds/background_hakis.png',
        'assets/img/restaurants/backgrounds/beirut.jpg',
        'assets/img/restaurants/backgrounds/celery.jpg',
        'assets/img/restaurants/backgrounds/chicos.jpg',
        'assets/img/restaurants/backgrounds/fine.jpg',
        'assets/img/restaurants/backgrounds/fortuna.jpg',
        'assets/img/restaurants/backgrounds/gold_dragon.jpg',
        'assets/img/restaurants/backgrounds/hakis.jpg',
        'assets/img/restaurants/backgrounds/holy rice.jpg',
        'assets/img/restaurants/backgrounds/indisch.png',
        'assets/img/restaurants/backgrounds/just_lecker.jpg',
        'assets/img/restaurants/backgrounds/khaohom_thai.jpg',
        'assets/img/restaurants/backgrounds/orchid.jpg',
        'assets/img/restaurants/backgrounds/pak-royal.jpg',
        'assets/img/restaurants/backgrounds/pizza_cab.jpg',
        'assets/img/restaurants/backgrounds/round_two.jpg',
        'assets/img/restaurants/backgrounds/royal_3.jpg',
        'assets/img/restaurants/backgrounds/sinbads.jpg',
        'assets/img/restaurants/backgrounds/tandoori_palace.jpg',
        'assets/img/restaurants/backgrounds/zu_dis_asia.jpg'
    ];

    private const LOGOS = [
        'assets/img/restaurants/logos/2_brueder.png',
        'assets/img/restaurants/logos/amore.png',
        'assets/img/restaurants/logos/asia_china_imbiss.png',
        'assets/img/restaurants/logos/asia_thai.png',
        'assets/img/restaurants/logos/athos.png',
        'assets/img/restaurants/logos/background_hakis.png',
        'assets/img/restaurants/logos/beirut.png',
        'assets/img/restaurants/logos/celery.png',
        'assets/img/restaurants/logos/chicos.png',
        'assets/img/restaurants/logos/fine.png',
        'assets/img/restaurants/logos/fortuna.png',
        'assets/img/restaurants/logos/gold_dragon.png',
        'assets/img/restaurants/logos/hakis.png',
        'assets/img/restaurants/logos/holy rice.png',
        'assets/img/restaurants/logos/indisch.png',
        'assets/img/restaurants/logos/just_lecker.png',
        'assets/img/restaurants/logos/khaohom_thai.png',
        'assets/img/restaurants/logos/orchid.png',
        'assets/img/restaurants/logos/pak-royal.png',
        'assets/img/restaurants/logos/pizza_cab.png',
        'assets/img/restaurants/logos/round_two.png',
        'assets/img/restaurants/logos/royal_3.png',
        'assets/img/restaurants/logos/sinbads.png',
        'assets/img/restaurants/logos/tandoori_palace.png',
        'assets/img/restaurants/logos/zu_dis_asia.png'
    ];

    private const NAMES = [
        '2_brueder',
        'amore',
        'asia_china_imbiss',
        'asia_thai',
        'athos',
        '_hakis',
        'beirut',
        'celery',
        'chicos',
        'fine',
        'fortuna',
        'gold_dragon',
        'hakis',
        'holy rice',
        'indisch',
        'just_lecker',
        'khaohom_thai',
        'orchid',
        'pak-royal',
        'pizza_cab',
        'round_two',
        'royal_3',
        'sinbads',
        'tandoori_palace',
        'zu_dis_asia',
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
            'background_url' => self::faker()->randomElement(self::BACKGROUND_PHOTOS),
            'logoFile' => self::faker()->imageUrl(),
            'logoUrl' => self::faker()->randomElement(self::LOGOS),
            'name' => self::faker()->randomElement(self::NAMES),
            'shopUrl' => self::faker()->url(),
            'categories' => [self::faker()->name(), self::faker()->name()],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this// ->afterInstantiate(function(Restaurant $restaurant): void {})
            ;
    }

    protected static function getClass(): string
    {
        return Restaurant::class;
    }
}
