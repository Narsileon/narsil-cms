import { create } from "zustand";
import { createJSONStorage, persist } from "zustand/middleware";

type RadiusStoreState = {
  radius: number;
};

type RadiusStoreActions = {
  applyRadius: () => void;
  setRadius: (radius: number) => void;
};

type RadiusStoreType = RadiusStoreState & RadiusStoreActions;

const useRadiusStore = create<RadiusStoreType>()(
  persist(
    (set, get) => ({
      radius: 0.65,
      applyRadius: () => {
        const root = window.document.documentElement;

        root.style.setProperty("--radius", `${get().radius}rem`);
      },
      setRadius: (radius) => {
        set({
          radius: radius,
        });

        get().applyRadius();
      },
    }),
    {
      name: `narsil-cms:radius`,
      storage: createJSONStorage(() => localStorage),
    },
  ),
);

export { useRadiusStore };
