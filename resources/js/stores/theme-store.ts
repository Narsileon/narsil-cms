import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";

export const themes = ["system", "light", "dark"] as const;

export type Theme = (typeof themes)[number];

type ThemeStoreState = {
  theme: Theme;
};

type ThemeStoreActions = {
  applyTheme: () => void;
  setTheme: (theme: Theme) => void;
};

export type ThemeStoreType = ThemeStoreState & ThemeStoreActions;

const useThemeStore = create<ThemeStoreType>()(
  persist(
    (set, get) => ({
      theme: "system",
      applyTheme: () => {
        const root = window.document.documentElement;

        root.classList.remove("light", "dark");

        if (get().theme === "system") {
          const systemTheme = window.matchMedia("(prefers-color-scheme: dark)")
            .matches
            ? "dark"
            : "light";

          root.classList.add(systemTheme);

          return;
        }

        root.classList.add(get().theme);
      },
      setTheme: (theme) =>
        set({
          theme: theme,
        }),
    }),
    {
      name: `narsil-cms:theme`,
      storage: createJSONStorage(() => localStorage),
    },
  ),
);

export default useThemeStore;
