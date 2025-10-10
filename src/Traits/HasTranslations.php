<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasTranslations
{
    #region PROPERTIES

    /**
     * @var array<string>
     */
    protected array $translatable = [];

    #endregion

    #region PUBLIC METHODS

    public function initializeHasTranslations(): void
    {
        $this->mergeCasts(
            array_fill_keys($this->getTranslatableAttributes(), 'json'),
        );
    }

    public function toArray()
    {

        $attributes = $this->attributesToArray();

        $translatables = array_filter($this->getTranslatableAttributes(), function ($key) use ($attributes)
        {
            return array_key_exists($key, $attributes);
        });
        foreach ($translatables as $field)
        {
            $attributes[$field] = $this->getTranslation($field, App::getLocale());
        }
        return array_merge($attributes, $this->relationsToArray());
    }

    public function getAttributeValue($key): mixed
    {
        if (! $this->isTranslatableAttribute($key))
        {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslation($key, App::getLocale(), App::getFallbackLocale());
    }

    protected function mutateAttributeForArray($key, $value): mixed
    {
        if (! $this->isTranslatableAttribute($key))
        {
            return parent::mutateAttributeForArray($key, $value);
        }

        $translations = $this->getTranslations($key);

        return array_map(fn($value) => parent::mutateAttributeForArray($key, $value), $translations);
    }

    public function setAttribute($key, $value)
    {
        if (! $this->isTranslatableAttribute($key))
        {
            return parent::setAttribute($key, $value);
        }

        if (is_array($value) && (! array_is_list($value) || count($value) === 0))
        {
            return $this->setTranslations($key, $value);
        }

        return $this->setTranslation($key, App::getLocale(), $value);
    }

    public function translate(string $key, string $locale = '', bool $useFallbackLocale = true): mixed
    {
        return $this->getTranslation($key, $locale, $useFallbackLocale);
    }

    public function getTranslations(?string $key = null, ?array $allowedLocales = null): array
    {
        if ($key !== null)
        {
            if ($this->isNestedKey($key))
            {
                [$key, $nestedKey] = explode('.', str_replace('->', '.', $key), 2);
            }

            return array_filter(
                Arr::get($this->fromJson($this->getAttributeFromArray($key)), $nestedKey ?? null, []),
                fn($value, $locale) => $this->filterTranslations($value, $locale, $allowedLocales, false, true),
                ARRAY_FILTER_USE_BOTH,
            );
        }

        return array_reduce($this->getTranslatableAttributes(), function ($result, $item) use ($allowedLocales)
        {
            $result[$item] = $this->getTranslations($item, $allowedLocales);

            return $result;
        });
    }

    public function getTranslatableAttributes(): array
    {
        return is_array($this->translatable)
            ? $this->translatable
            : [];
    }

    public function setTranslation(string $key, string $locale, mixed $value): void
    {
        $translations = $this->getTranslations($key);

        $mutatorKey = str_replace('->', '-', $key);

        if ($this->hasSetMutator($mutatorKey))
        {
            $method = 'set' . Str::studly($mutatorKey) . 'Attribute';

            $this->{$method}($value, $locale);

            $value = $this->attributes[$key];
        }
        else if ($this->hasAttributeSetMutator($mutatorKey))
        {
            $this->setAttributeMarkedMutatedAttributeValue($mutatorKey, $value);

            $value = $this->attributes[$mutatorKey];
        }

        $translations[$locale] = $value;

        if ($this->isNestedKey($key))
        {
            unset($this->attributes[$key], $this->attributes[$mutatorKey]);

            $this->fillJsonAttribute($key, $translations);
        }
        else
        {
            $this->attributes[$key] = json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return void
     */
    public function forgetTranslation(string $key, string $locale): void
    {
        $translations = $this->getTranslations($key);

        unset($translations[$locale], $this->$key);

        $this->setTranslations($key, $translations);
    }

    /**
     * @param string $locale
     *
     * @return void
     */
    public function forgetAllTranslations(string $locale): void
    {
        collect($this->getTranslatableAttributes())->each(function (string $attribute) use ($locale)
        {
            $this->forgetTranslation($attribute, $locale);
        });
    }

    public function getTranslatedLocales(string $key): array
    {
        return array_keys($this->getTranslations($key));
    }

    public function isNestedKey(string $key): bool
    {
        return str_contains($key, '->');
    }

    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes());
    }

    public function hasTranslation(string $key, ?string $locale = null): bool
    {
        $locale = $locale ?: App::getLocale();

        return isset($this->getTranslations($key)[$locale]);
    }

    public function replaceTranslations(string $key, array $translations): self
    {
        foreach ($this->getTranslatedLocales($key) as $locale)
        {
            $this->forgetTranslation($key, $locale);
        }

        $this->setTranslations($key, $translations);

        return $this;
    }

    protected function normalizeLocale(string $key, string $locale, bool $useFallbackLocale): string
    {
        $translatedLocales = $this->getTranslatedLocales($key);

        if (in_array($locale, $translatedLocales))
        {
            return $locale;
        }

        if (! $useFallbackLocale)
        {
            return $locale;
        }

        $fallbackLocale = App::getFallbackLocale();

        if (! is_null($fallbackLocale) && in_array($fallbackLocale, $translatedLocales))
        {
            return $fallbackLocale;
        }

        return $locale;
    }

    protected function filterTranslations(mixed $value = null, ?string $locale = null, ?array $allowedLocales = null, bool $allowNull = false, bool $allowEmptyString = false): bool
    {
        if ($value === null && ! $allowNull)
        {
            return false;
        }

        if ($value === '' && ! $allowEmptyString)
        {
            return false;
        }

        if ($allowedLocales === null)
        {
            return true;
        }

        if (! in_array($locale, $allowedLocales))
        {
            return false;
        }

        return true;
    }

    public function translations(): Attribute
    {
        return Attribute::get(function ()
        {
            return collect($this->getTranslatableAttributes())
                ->mapWithKeys(function (string $key)
                {
                    return [$key => $this->getTranslations($key)];
                })
                ->toArray();
        });
    }

    /**
     * @param string $key
     * @param array<string,mixed> $translations
     *
     * @return void
     */
    public function setTranslations(string $key, array $translations): void
    {
        if (!empty($translations))
        {
            foreach ($translations as $locale => $translation)
            {
                $this->setTranslation($key, $locale, $translation);
            }
        }
        else
        {
            $this->attributes[$key] = $this->asJson([]);
        }
    }

    #region • ATTRIBUTES

    /**
     * @param string $key
     * @param string $locale
     * @param boolean $fallback
     *
     * @return mixed
     */
    public function getTranslation(string $key, string $locale, bool $fallback = true): mixed
    {
        $normalizedLocale = $this->normalizeLocale($key, $locale, $fallback);

        $translations = $this->getTranslations($key);

        $baseKey = Str::before($key, '->');

        if (is_null(self::getAttributeFromArray($baseKey)))
        {
            $translation = null;
        }
        else
        {
            $translation = isset($translations[$normalizedLocale]) ? $translations[$normalizedLocale] : null;
            $translation ??= '';
        }

        $key = str_replace('->', '-', $key);

        if ($this->hasGetMutator($key))
        {
            return $this->mutateAttribute($key, $translation);
        }

        if ($this->hasAttributeMutator($key))
        {
            return $this->mutateAttributeMarkedAttribute($key, $translation);
        }

        return $translation;
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return mixed
     */
    public function getTranslationWithFallback(string $key, string $locale): mixed
    {
        return $this->getTranslation($key, $locale, true);
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return mixed
     */
    public function getTranslationWithoutFallback(string $key, string $locale): mixed
    {
        return $this->getTranslation($key, $locale, false);
    }

    #endregion

    #region • SCOPES

    /**
     * @param Builder $query
     * @param string $column
     * @param string $locale
     * @param mixed $value
     * @param string $operator
     *
     * @return void
     */
    public function scopeWhereJsonContainsLocale(Builder $query, string $column, string $locale, mixed $value, string $operator = '='): void
    {
        $query->where("{$column}->{$locale}", $operator, $value);
    }

    /**
     * Undocumented function
     *
     * @param Builder $query
     * @param string $column
     * @param array $locales
     * @param mixed $value
     * @param string $operator
     *
     * @return void
     */
    public function scopeWhereJsonContainsLocales(Builder $query, string $column, array $locales, mixed $value, string $operator = '='): void
    {
        $query->where(function (Builder $query) use ($column, $locales, $value, $operator)
        {
            foreach ($locales as $locale)
            {
                $query->orWhere("{$column}->{$locale}", $operator, $value);
            }
        });
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $locale
     *
     * @return void
     */
    public function scopeWhereLocale(Builder $query, string $column, string $locale): void
    {
        $query->whereNotNull("{$column}->{$locale}");
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param array $locales
     *
     * @return void
     */
    public function scopeWhereLocales(Builder $query, string $column, array $locales): void
    {
        $query->where(function (Builder $query) use ($column, $locales)
        {
            foreach ($locales as $locale)
            {
                $query->orWhereNotNull("{$column}->{$locale}");
            }
        });
    }

    #endregion

    #endregion
}
