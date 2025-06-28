import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";

export const colors = [
  "default",
  "red",
  "orange",
  "amber",
  "yellow",
  "lime",
  "green",
  "emerald",
  "teal",
  "cyan",
  "sky",
  "blue",
  "indigo",
  "violet",
  "purple",
  "fuchsia",
  "pink",
  "rose",
] as const;

export type Color = (typeof colors)[number];

export type ColorStoreState = {
  color: Color;
};

export type ColorStoreActions = {
  applyColor: () => void;
  setColor: (color: Color) => void;
};

export type ColorStoreType = ColorStoreState & ColorStoreActions;

const useColorStore = create<ColorStoreType>()(
  persist(
    (set, get) => ({
      color: "default",
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

export default useColorStore;
