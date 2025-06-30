import { create } from "zustand";
import { upperFirst } from "lodash";

type TranslationOptions = {
  replacements?: Record<string, string | number>;
};

export type TranslationStoreState = {
  locale: string;
  locales: string[];
  translations: Record<string, string>;
};

export type TranslationStoreActions = {
  setLocale: (locale: string) => void;
  setLocales: (locales: string[]) => void;
  setTranslations: (translations: Record<string, string>) => void;
  trans: (
    key: string,
    fallback: string,
    options?: TranslationOptions,
  ) => string;
};

export type TranslationStoreType = TranslationStoreState &
  TranslationStoreActions;

const useTranslationsStore = create<TranslationStoreType>((set, get) => ({
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
  trans: (key, fallback = "Translation not found", options = {}) => {
    const { replacements = {} } = options;

    let text = get().translations?.[key] ?? fallback;

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
}));

export default useTranslationsStore;
