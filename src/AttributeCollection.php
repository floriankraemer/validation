<?php declare(strict_types=1);

namespace Somnambulist\Components\Validation;

use InvalidArgumentException;

/**
 * Class AttributeBag
 *
 * @package    Somnambulist\Components\Validation
 * @subpackage Somnambulist\Components\Validation\AttributeBag
 *
 * @property array<string, Attribute> $data
 */
class AttributeCollection extends Collection
{
    public function add(string $key, Attribute $attribute): self
    {
        $this->set($key, $attribute);

        return $this;
    }

    public function beforeValidate(): void
    {
        $this->each(fn (Attribute $a) => $a->rules()->beforeValidate());
    }

    public function set(string $key, mixed $value): static
    {
        if (!$value instanceof Attribute) {
            throw new InvalidArgumentException(sprintf('Value must be an instance of %s', Attribute::class));
        }

        return parent::set($key, $value);
    }
}
