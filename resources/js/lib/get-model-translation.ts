import { get, isObject } from "lodash-es";

function getModelTranslation(
  attribute: string | Record<string, unknown>,
  language: string,
  fallbackLanguage?: string,
): string {
  let value = "";

  if (isObject(attribute)) {
    value = get(attribute, language, "") as string;

    if (!value && fallbackLanguage) {
      value = get(attribute, fallbackLanguage, "") as string;
    }
  }

  return value;
}

export default getModelTranslation;
