import { clsx, type ClassValue } from "clsx";
import { get, isObject, isString } from "lodash-es";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function getSelectOption(
  option: string | Record<string, unknown> | string,
  key: string,
): string {
  const value = isString(option) ? option : get(option, key);

  return value as string;
}

export function getTranslatableSelectOption(
  option: string | Record<string, unknown>,
  key: string,
  language: string,
  fallbackLanguage?: string,
): string {
  let value = isString(option) ? option : get(option, key);

  if (isObject(value)) {
    let translatedValue = get(value, language);

    if (!translatedValue && fallbackLanguage) {
      translatedValue = get(value, fallbackLanguage);
    }

    if (!translatedValue) {
      const firstKey = Object.keys(value)[0];

      translatedValue = get(value, firstKey, "");
    }

    value = translatedValue;
  }

  return value as string;
}
