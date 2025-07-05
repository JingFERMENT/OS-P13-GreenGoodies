<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;


/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    private static ?string $hashedPassword = null;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        // Hash the password once and store it for reuse
        if (self::$hashedPassword === null) {
            self::$hashedPassword = $passwordHasher->hashPassword(new User(), 'password123');
        }
    }

    public static function class(): string
    {
        return User::class;
    }

        /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable    {
        return [
            'email' => self::faker()->unique()->safeEmail(),
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'isAcceptedCGU' => self::faker()->boolean(),
            'isActivatedAPI' => self::faker()->boolean(),
            'password' => self::$hashedPassword,
        ];
    }

        /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(User $user): void {})
        ;
    }
}
