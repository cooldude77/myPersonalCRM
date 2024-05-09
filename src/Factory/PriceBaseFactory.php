<?php

namespace App\Factory;

use App\Entity\PriceBase;
use App\Repository\PriceBaseRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PriceBase>
 *
 * @method        PriceBase|Proxy                     create(array|callable $attributes = [])
 * @method static PriceBase|Proxy                     createOne(array $attributes = [])
 * @method static PriceBase|Proxy                     find(object|array|mixed $criteria)
 * @method static PriceBase|Proxy                     findOrCreate(array $attributes)
 * @method static PriceBase|Proxy                     first(string $sortedField = 'id')
 * @method static PriceBase|Proxy                     last(string $sortedField = 'id')
 * @method static PriceBase|Proxy                     random(array $attributes = [])
 * @method static PriceBase|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PriceBaseRepository|RepositoryProxy repository()
 * @method static PriceBase[]|Proxy[]                 all()
 * @method static PriceBase[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static PriceBase[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static PriceBase[]|Proxy[]                 findBy(array $attributes)
 * @method static PriceBase[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static PriceBase[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PriceBaseFactory extends ModelFactory
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
            'currency' => CurrencyFactory::new(),
            'price' => self::faker()->randomFloat(),
            'product' => ProductFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(PriceBase $priceBase): void {})
        ;
    }

    protected static function getClass(): string
    {
        return PriceBase::class;
    }
}
