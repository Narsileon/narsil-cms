import { create } from "zustand";
import { upperFirst } from "lodash";

type TranslationOptions = {
  replacements?: Record<string, string | number>;
};

type TranslationStoreState = {
  locale: string;
  locales: string[];
  translations: Record<string, string>;
  setLocale: (locale: string) => void;
  setLocales: (locales: string[]) => void;
  setTranslations: (translations: Record<string, string>) => void;
  trans: (key: string, options?: TranslationOptions) => string;
};

export const useTranslationsStore = create<TranslationStoreState>(
  (set, get) => ({
    locale: "",
    locales: [],
    translations: {},
    setLocale: (locale) =>
      set({
        locale: locale,
      }),
    setLocales: (locales) =>
      set({
        locales: locales,
      }),
    setTranslations: (translations) =>
      set({
        translations: translations,
      }),
    trans: (key, options = {}) => {
      const { replacements = {} } = options;
      console.log(get().translations);
      let text = get().translations?.[key] ?? key.split(".").pop() ?? key;

      Object.entries(replacements).map(([replacementKey, replacementValue]) => {
        if (text.includes(replacementKey)) {
          text = text.replace(`:${replacementKey}`, `${replacementValue}`);
        } else if (text.includes(upperFirst(replacementKey))) {
          text = text.replace(
            `:${upperFirst(replacementKey)}`,
            upperFirst(`${replacementValue}`),
          );
        }
      });

      return text;
    },
  }),
);
