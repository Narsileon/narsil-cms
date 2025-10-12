import { Field } from "@narsil-cms/types";
import { isEmpty } from "lodash";

function getFieldDefaultValue(field: Field) {
  let defaultValue = (field.settings as Record<string, unknown>)?.value ?? "";

  if (field.translatable && isEmpty(defaultValue)) {
    defaultValue = {};
  }

  return defaultValue;
}

export { getFieldDefaultValue };
