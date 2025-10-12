import { clsx, type ClassValue } from "clsx";
import { get, isObject, isString } from "lodash";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function getSelectOption(
  option: string | Record<string, unknown> | string,
  key: string,
): string {
  const label = isString(option) ? option : get(option, key);

  return label as string;
}

export function getTranslatableSelectOption(
  option: string | Record<string, unknown>,
  key: string,
  language: string,
): string {
  let label = isString(option) ? option : get(option, key);

  if (isObject(label)) {
    label = get(label, language);
  }

  return label as string;
}
