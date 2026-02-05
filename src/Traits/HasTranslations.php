<?php

namespace Narsil\Cms\Traits;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Narsil\Cms\Casts\JsonCast;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasTranslations
{
    #region PROPERTIES

    /**
     * @var array<string>
     */
    final protected array $translatable = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return void
     */
    final public function initializeHasTranslations(): void
    {
        $casts = array_fill_keys($this->translatable, JsonCast::class);

        $this->mergeCasts($casts);
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return void
     */
    final public function forgetTranslation(string $key, string $locale): void
    {
        $translations = $this->getTranslations($key);

        unset($translations[$locale], $this->$key);

        $this->setTranslations($key, $translations);
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return mixed
     */
    final public function getTranslationWithFallback(string $key, string $locale): mixed
    {
        return $this->getTranslation($key, $locale, true);
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return mixed
     */
    final public function getTranslationWithoutFallback(string $key, string $locale): mixed
    {
        return $this->getTranslation($key, $locale, false);
    }

    /**
     * @param string $key
     * @param string|null $locale
     *
     * @return boolean
     */
    final public function hasTranslation(string $key, ?string $locale = null): bool
    {
        $locale = $locale ?: App::getLocale();

        return Arr::has($this->getTranslations($key), $locale);
    }

    /**
     * @param string $key
     *
     * @return boolean
     */
    final public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->translatable);
    }

    /**
     * @param string $key
     * @param array $translations
     *
     * @return void
     */
    final public function replaceTranslations(string $key, array $translations): void
    {
        foreach ($this->getTranslatedLocales($key) as $locale)
        {
            $this->forgetTranslation($key, $locale);
        }

        $this->setTranslations($key, $translations);
    }

    /**
     * @param string $key
     * @param string $locale
     * @param mixed $value
     *
     * @return void
     */
    final public function setTranslation(string $key, string $locale, mixed $value): void
    {
        $translations = $this->getTranslations($key);

        $translations[$locale] = $value;

        $this->attributes[$key] = json_encode($translations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param string $key
     * @param array<string,mixed> $translations
     *
     * @return void
     */
    final public function setTranslations(string $key, array $translations): void
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
            $this->attributes[$key] = null;
        }
    }

    /**
     * {@inheritDoc}
     */
    final public function toArray(): array
    {
        $attributes = parent::toArray();

        $translatables = array_filter($this->translatable, function ($key) use ($attributes)
        {
            return array_key_exists($key, $attributes);
        });

        foreach ($translatables as $translatable)
        {
            $attributes[$translatable] = $this->getTranslation($translatable, App::getLocale(), true);
        }

        return $attributes;
    }

    /**
     * @return array
     */
    final public function toArrayWithTranslations(): array
    {
        $attributes = parent::toArray();

        foreach ($this->translatable ?? [] as $key)
        {
            if ($this->hasTranslation($key))
            {
                $attributes[$key] = $this->getTranslations($key);
            }
        }

        foreach ($this->getRelations() as $relation => $model)
        {
            if ($model instanceof Collection)
            {
                $attributes[$relation] = $model->map(function ($item)
                {
                    return method_exists($item, 'toArrayWithTranslations')
                        ? $item->toArrayWithTranslations()
                        : $item->toArray();
                })->all();
            }
            elseif ($model instanceof Model)
            {
                $attributes[$relation] = method_exists($model, 'toArrayWithTranslations')
                    ? $model->toArrayWithTranslations()
                    : $model->toArray();
            }
        }

        return $attributes;
    }

    #region • ATTRIBUTES

    /**
     * {@inheritDoc}
     */
    final public function getAttributeValue($key): mixed
    {
        if (!$this->isTranslatableAttribute($key))
        {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslation($key, App::getLocale(), true);
    }

    /**
     * {@inheritDoc}
     */
    final public function setAttribute($key, $value): void
    {
        if (!$this->isTranslatableAttribute($key))
        {
            parent::setAttribute($key, $value);

            return;
        }

        if (is_array($value) && (!array_is_list($value) || count($value) === 0))
        {
            $this->setTranslations($key, $value);

            return;
        }

        $this->setTranslation($key, App::getLocale(), $value);

        return;
    }

    #endregion

    #region • SCOPES

    /**
     * @param Builder $query
     * @param string $locale
     * @param string $column
     * @param string $operator
     * @param mixed $value
     *
     * @return void
     */
    final public function scopeWhereLocale(Builder $query, string $locale, string $column, string $operator, mixed $value): void
    {
        $query->where("{$column}->{$locale}", $operator, $value);
    }

    /**
     * @param Builder $query
     * @param array $locales
     * @param string $column
     * @param string $operator
     * @param mixed $value
     *
     * @return void
     */
    final public function scopeWhereLocales(Builder $query, array $locales, string $column, string $operator, mixed $value): void
    {
        $query->where(function (Builder $query) use ($column, $locales, $operator, $value)
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
    final public function scopeWhereHasLocale(Builder $query, string $column, string $locale): void
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
    final public function scopeWhereHasLocales(Builder $query, string $column, array $locales): void
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

    #region PROTECTED METHODS

    /**
     * @param mixed $value
     *
     * @return boolean
     */
    final protected function filterTranslations(mixed $value = null): bool
    {
        if ($value === null)
        {
            return false;
        }

        if ($value === '')
        {
            return false;
        }

        return true;
    }

    /**
     * @param string $key
     * @param string $locale
     * @param boolean $fallback
     *
     * @return string
     */
    final protected function getNormalizedLocale(string $key, string $locale, bool $fallback): string
    {
        $translatedLocales = $this->getTranslatedLocales($key);

        if (in_array($locale, $translatedLocales))
        {
            return $locale;
        }

        if (!$fallback)
        {
            return $locale;
        }

        if ($fallback)
        {
            $fallbackLocale = App::getFallbackLocale();

            if ($fallbackLocale && in_array($fallbackLocale, $translatedLocales))
            {
                return $fallbackLocale;
            }
        }

        if (!empty($translatedLocales))
        {
            return $translatedLocales[0];
        }

        return $locale;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    final protected function getTranslatedLocales(string $key): array
    {
        return array_keys($this->getTranslations($key));
    }

    /**
     * @param string $key
     * @param string $locale
     * @param boolean $fallback
     *
     * @return mixed
     */
    final protected function getTranslation(string $key, string $locale, bool $fallback = false): mixed
    {
        $normalizedLocale = $this->getNormalizedLocale($key, $locale, $fallback);

        $translations = $this->getTranslations($key);

        $translation = Arr::get($translations, $normalizedLocale, '');

        return $translation;
    }

    /**
     * @param string|null $key
     * @param array|null $allowedLocales
     *
     * @return array
     */
    final public function getTranslations(?string $key = null, ?array $allowedLocales = null): array
    {
        if ($key !== null)
        {
            return array_filter(
                $this->fromJson($this->getAttributeFromArray($key)) ?? [],
                function ($value)
                {
                    return $this->filterTranslations($value);
                },
                ARRAY_FILTER_USE_BOTH
            );
        }

        return array_reduce($this->translatable, function ($result, $item) use ($allowedLocales)
        {
            $result[$item] = $this->getTranslations($item, $allowedLocales);

            return $result;
        }, []);
    }

    #endregion
}
