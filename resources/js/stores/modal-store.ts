import { Link } from "@inertiajs/react";
import { DialogContent } from "@narsil-ui/components/dialog";
import { type ComponentProps } from "react";
import { create } from "zustand";

type LinkProps = ComponentProps<typeof Link>;
type ModalVariant = ComponentProps<typeof DialogContent>["variant"];

type ModalType = {
  component: string;
  componentProps: Record<string, unknown>;
  id: string;
  linkProps: LinkProps;
  variant: ModalVariant;
};

type ModalStoreState = {
  modals: ModalType[];
};

type ModalStoreActions = {
  closeModal: (href: string) => void;
  closeTopModal: () => void;
  openModal: (linkProps: LinkProps, variant?: ModalVariant) => Promise<void>;
  reloadTopModal: () => Promise<void>;
};

type ModalStoreType = ModalStoreState & ModalStoreActions;

async function fetchModalProps(
  linkProps: LinkProps,
  variant?: ModalVariant,
): Promise<ModalType | null> {
  try {
    const url = new URL(linkProps.href as string, window.location.origin);

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
      id: crypto.randomUUID(),
      linkProps: linkProps,
      variant: variant,
    };
  } catch (error) {
    console.error(error);

    return null;
  }
}

const useModalStore = create<ModalStoreType>((set, get) => ({
  modals: [],

  closeModal: (href) =>
    set((state) => ({
      modals: state.modals.filter((m) => m.linkProps?.href !== href),
    })),
  closeTopModal: () =>
    set((state) => ({
      modals: state.modals.slice(0, -1),
    })),
  openModal: async (linkProps: LinkProps, variant?: ModalVariant) => {
    const modal = await fetchModalProps(linkProps, variant);

    if (!modal) {
      return;
    }

    set((state) => ({
      modals: [...state.modals, { ...modal }],
    }));
  },
  reloadTopModal: async () => {
    const topModal = get().modals.at(-1);

    if (!topModal) {
      return;
    }
    const modal = await fetchModalProps(topModal.linkProps);

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

export { useModalStore };

export type { ModalType };
