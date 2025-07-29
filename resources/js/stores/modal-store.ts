import { create } from "zustand";
import type { FormDataConvertible, VisitCallbacks } from "@inertiajs/core";

export type ModalState = {
  component: string;
  componentProps: Record<string, any>;
  href: string;
  options?: Partial<VisitCallbacks>;
};

type ModalStoreState = {
  modals: ModalState[];
};

type ModalStoreActions = {
  closeModal: (href: string) => void;
  closeTopModal: () => void;
  openModal: (href: string, options?: Partial<VisitCallbacks>) => Promise<void>;
  reloadTopModal: () => Promise<void>;
};

export type ModalStoreType = ModalStoreState & ModalStoreActions;

async function fetchModalProps(href: string): Promise<ModalState | null> {
  try {
    const url = new URL(href, window.location.origin);

    url.searchParams.set("_modal", "1");

    const response = await fetch(url.toString(), {
      headers: {
        Accept: "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Failed to fetch modal");
    }

    const data = await response.json();

    if (!data?.component) {
      throw new Error("Invalid modal response");
    }

    return {
      component: data.component,
      componentProps: data.props ?? {},
      href: href,
    };
  } catch (error) {
    console.error(error);

    return null;
  }
}

export const useModalStore = create<ModalStoreType>((set, get) => ({
  modals: [],

  closeModal: (href) =>
    set((state) => ({
      modals: state.modals.filter((m) => m.href !== href),
    })),
  closeTopModal: () =>
    set((state) => ({
      modals: state.modals.slice(0, -1),
    })),
  openModal: async (href, options) => {
    const modal = await fetchModalProps(href);

    if (!modal) {
      return;
    }

    set((state) => ({
      modals: [...state.modals, { ...modal, options: options }],
    }));
  },
  reloadTopModal: async () => {
    const topModal = get().modals.at(-1);

    if (!topModal) {
      return;
    }
    const modal = await fetchModalProps(topModal.href);

    if (!modal) {
      return;
    }

    set((state) => {
      const updated = [...state.modals];

      updated[updated.length - 1] = modal;

      return { modals: updated };
    });
  },
}));
