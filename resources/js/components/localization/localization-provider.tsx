import { get } from "lodash";
import { useEffect, useState } from "react";
import { LocalizationContext } from "./localization-context";

type LocalizationProviderProps = {
  children: React.ReactNode;
  translations: Record<string, string>;
};

const LocalizationProvider = ({
  children,
  translations: initialTranslations,
}: LocalizationProviderProps) => {
  const [translations, setTranslations] = useState<Record<string, string>>(initialTranslations);

  useEffect(() => {
    setTranslations((prev) => ({
      ...prev,
      ...initialTranslations,
    }));
  }, [initialTranslations]);

  return (
    <LocalizationContext.Provider
      value={{
        addTranslations: (translations) => {
          setTranslations((prev) => ({
            ...prev,
            ...translations,
          }));
        },
        trans: (key, options) => {
          let trans = get(translations, key) ?? "No translation found";

          if (options?.replacements) {
            Object.entries(options?.replacements).forEach(([placeholder, value]) => {
              const regex = new RegExp(`:${placeholder}`, "g");

              trans = trans.replace(regex, String(value));
            });
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
