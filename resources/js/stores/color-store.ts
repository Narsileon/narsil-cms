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
      },
    }),
    {
      name: `narsil-cms:color`,
      storage: createJSONStorage(() => localStorage),
    },
  ),
);

export { useColorStore };
