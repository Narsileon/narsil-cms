import { createContext, useContext } from "react";

export type Theme = "dark" | "light" | "system";

export type ThemeContextProps = {
  theme: Theme;
  setTheme: (theme: Theme) => void;
};

export const ThemeProviderContext = createContext<ThemeContextProps>({
  theme: "system",
  setTheme: () => null,
});

function useTheme() {
  const context = useContext(ThemeProviderContext);

  if (!context) {
    throw new Error("useTheme must be used within a ThemeProvider.");
  }

  return context;
}

export default useTheme;
