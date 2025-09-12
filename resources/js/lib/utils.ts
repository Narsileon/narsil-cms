import { clsx, type ClassValue } from "clsx";
import { get, isString } from "lodash";
import { twMerge } from "tailwind-merge";

import { type SelectOption } from "@narsil-cms/types/forms";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function getSelectOption(
  option: SelectOption | string,
  key: string,
): string {
  const label = isString(option) ? option : get(option, key);

  return label;
}
