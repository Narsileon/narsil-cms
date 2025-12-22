import { router } from "@inertiajs/react";
import { debounce } from "lodash-es";
import { route } from "ziggy-js";
import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";

type ColorStoreState = {
  color: string;
};

type ColorStoreActions = {
  applyColor: () => void;
  setColor: (color: string) => void;
};

type ColorStoreType = ColorStoreState & ColorStoreActions;

const debouncedSave = debounce((color: string) => {
  router.post(
    route("user-configurations.update"),
    {
      color: color,
    },
    {
      preserveState: true,
    },
  );
}, 500);

const useColorStore = create<ColorStoreType>()(
  persist(
    (set, get) => ({
      color: "neutral",
      applyColor: () => {
        const root = window.document.documentElement;

        root.setAttribute("data-color", get().color);
      },
      setColor: (color) => {
        set({
          color: color,
        });

        get().applyColor();

        debouncedSave(color);
      },
    }),
    {
      name: `narsil-cms:color`,
      storage: createJSONStorage(() => localStorage),
    },
  ),
);

export { useColorStore };
