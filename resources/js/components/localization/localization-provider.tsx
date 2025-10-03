import { get } from "lodash";
import { useState } from "react";

import { LocalizationContext } from "./localization-context";

type LocalizationProviderProps = {
  children: React.ReactNode;
  translations: Record<string, string>;
};

const LocalizationProvider = ({
  children,
  translations: initialTranslations,
}: LocalizationProviderProps) => {
  const [labels, setLabels] =
    useState<Record<string, string>>(initialTranslations);

  return (
    <LocalizationContext.Provider
      value={{
        addTranslations: (labels) => {
          setLabels((prev) => ({
            ...prev,
            ...labels,
          }));
        },
        trans: (key, options) => {
          let trans = get(labels, key) ?? "No translation found";

          if (options?.replacements) {
            Object.entries(options?.replacements).forEach(
              ([placeholder, value]) => {
                const regex = new RegExp(`:${placeholder}`, "g");

                trans = trans.replace(regex, String(value));
              },
            );
          }

          return trans;
        },
      }}
    >
      {children}
    </LocalizationContext.Provider>
  );
};

export default LocalizationProvider;
