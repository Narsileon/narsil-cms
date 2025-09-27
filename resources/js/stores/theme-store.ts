import { router } from "@inertiajs/react";
import { flushSync } from "react-dom";
import { route } from "ziggy-js";
import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";

const themes = ["light", "dark", "system"] as const;
type Theme = (typeof themes)[number];

type ThemeStoreState = {
  theme: Theme;
};
type ThemeStoreActions = {
  applyTheme: () => void;
  setTheme: (theme: Theme, origin?: { x: number; y: number }) => void;
};

type ThemeStoreType = ThemeStoreState & ThemeStoreActions;

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

        const { theme } = get();

        if (theme) {
          root.classList.add(theme);
        }
      },
      setTheme: (theme, origin) => {
        set({ theme });

        const root = document.documentElement;

        let newTheme: "light" | "dark";

        if (theme === "system") {
          newTheme = window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light";
        } else {
          newTheme = theme;
        }

        const apply = () => {
          flushSync(() => {
            root.classList.remove("light", "dark");
            root.classList.add(newTheme);
          });
        };

        if (document.startViewTransition) {
          document.startViewTransition(apply).ready.then(() => {
            if (!origin) {
              return;
            }

            const { x, y } = origin;

            const maxRadius = Math.hypot(
              Math.max(x, window.innerWidth - x),
              Math.max(y, window.innerHeight - y),
            );

            root.animate(
              {
                clipPath: [
                  `circle(0px at ${x}px ${y}px)`,
                  `circle(${maxRadius}px at ${x}px ${y}px)`,
                ],
              },
              {
                duration: 700,
                easing: "ease-in-out",
                pseudoElement: "::view-transition-new(root)",
              },
            );
          });
        } else {
          apply();
        }

        router.post(
          route("user-configuration.store"),
          { theme: theme },
          { preserveState: false },
        );
      },
    }),
    {
      name: "narsil-cms:theme",
      storage: createJSONStorage(() => localStorage),
    },
  ),
);

export { themes, useThemeStore };

export type { Theme };
