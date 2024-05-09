<?php

namespace App\Factory;

use App\Entity\PinCode;
use App\Repository\PinCodeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PinCode>
 *
 * @method        PinCode|Proxy                     create(array|callable $attributes = [])
 * @method static PinCode|Proxy                     createOne(array $attributes = [])
 * @method static PinCode|Proxy                     find(object|array|mixed $criteria)
 * @method static PinCode|Proxy                     findOrCreate(array $attributes)
 * @method static PinCode|Proxy                     first(string $sortedField = 'id')
 * @method static PinCode|Proxy                     last(string $sortedField = 'id')
 * @method static PinCode|Proxy                     random(array $attributes = [])
 * @method static PinCode|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PinCodeRepository|RepositoryProxy repository()
 * @method static PinCode[]|Proxy[]                 all()
 * @method static PinCode[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static PinCode[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static PinCode[]|Proxy[]                 findBy(array $attributes)
 * @method static PinCode[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static PinCode[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PinCodeFactory extends ModelFactory
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
            'city' => CityFactory::new(),
            'pinCode' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(PinCode $pinCode): void {})
        ;
    }

    protected static function getClass(): string
    {
        return PinCode::class;
    }
}
