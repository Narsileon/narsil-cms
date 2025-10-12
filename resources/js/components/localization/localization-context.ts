import { createContext, useContext } from "react";

export type LocalizationOptions = {
  replacements?: Record<string, number | string>;
};

export type LocalizationContextProps = {
  addTranslations: (translations: Record<string, string>) => void;
  trans: (key: string, options?: LocalizationOptions) => string;
};

export const LocalizationContext = createContext<LocalizationContextProps>({
  addTranslations: () => {},
  trans: () => "string",
});

function useLocalization() {
  const context = useContext(LocalizationContext);

  if (!context) {
    throw new Error("useLocalization must be used within a LocalizationProvider");
  }

  return context;
}

export default useLocalization;
