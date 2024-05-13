<?php

namespace App\Factory;

use App\Entity\WebShop;
use App\Repository\WebShopRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<WebShop>
 *
 * @method        WebShop|Proxy                     create(array|callable $attributes = [])
 * @method static WebShop|Proxy                     createOne(array $attributes = [])
 * @method static WebShop|Proxy                     find(object|array|mixed $criteria)
 * @method static WebShop|Proxy                     findOrCreate(array $attributes)
 * @method static WebShop|Proxy                     first(string $sortedField = 'id')
 * @method static WebShop|Proxy                     last(string $sortedField = 'id')
 * @method static WebShop|Proxy                     random(array $attributes = [])
 * @method static WebShop|Proxy                     randomOrCreate(array $attributes = [])
 * @method static WebShopRepository|RepositoryProxy repository()
 * @method static WebShop[]|Proxy[]                 all()
 * @method static WebShop[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static WebShop[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static WebShop[]|Proxy[]                 findBy(array $attributes)
 * @method static WebShop[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static WebShop[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class WebShopFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'description' => self::faker()->text(255),
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(WebShop $webShop): void {})
        ;
    }

    protected static function getClass(): string
    {
        return WebShop::class;
    }
}
