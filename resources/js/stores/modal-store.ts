import { create } from "zustand";

export type ModalState = {
  component: string;
  componentProps: Record<string, any>;
  href: string;
};

type ModalStoreState = {
  modals: ModalState[];
};

type ModalStoreActions = {
  closeModal: (href: string) => void;
  closeTopModal: () => void;
  openModal: (href: string) => Promise<void>;
};

export type ModalStoreType = ModalStoreState & ModalStoreActions;

export const useModalStore = create<ModalStoreType>((set) => ({
  modals: [],

  closeModal: (href) =>
    set((state) => ({
      modals: state.modals.filter((m) => m.href !== href),
    })),
  closeTopModal: () =>
    set((state) => ({
      modals: state.modals.slice(0, -1),
    })),
  openModal: async (href) => {
    const fullUrl = new URL(href, window.location.origin);

    fullUrl.searchParams.set("_modal", "1");

    const response = await fetch(fullUrl.toString(), {
      headers: {
        Accept: "application/json",
      },
    });

    if (!response.ok) {
      console.error("Failed to fetch modal");

      return;
    }

    const data = await response.json();

    if (!data || !data.component) {
      console.error("Invalid modal response");

      return;
    }

    set((state) => ({
      modals: [
        ...state.modals,
        {
          component: data.component,
          componentProps: data.props,
          href: href,
        },
      ],
    }));
  },
}));
