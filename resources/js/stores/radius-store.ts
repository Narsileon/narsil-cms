import { router } from "@inertiajs/react";
import { debounce } from "lodash";
import { route } from "ziggy-js";
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

const debouncedSave = debounce((radius: number) => {
  router.post(
    route("user-configuration.store"),
    { radius: radius },
    { preserveState: true },
  );
}, 500);

const useRadiusStore = create<RadiusStoreType>()(
  persist(
    (set, get) => ({
      radius: 0.5,
      applyRadius: () => {
        const root = window.document.documentElement;

        root.style.setProperty("--radius", `${get().radius}rem`);
      },
      setRadius: (radius) => {
        set({
          radius: radius,
        });

        get().applyRadius();

        debouncedSave(radius);
      },
    }),
    {
      name: `narsil-cms:radius`,
      storage: createJSONStorage(() => localStorage),
    },
  ),
);

export { useRadiusStore };
