import { LabelsProvider } from "@narsil-cms/components/ui/labels";
import { ModalState } from "@narsil-cms/stores/modal-store";
import { useEffect, useState } from "react";
import { VisuallyHidden } from "@narsil-cms/components/ui/visually-hidden";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from "@narsil-cms/components/ui/dialog";
import type { ComponentProps, ComponentType } from "react";

type ModalProps = ComponentProps<typeof DialogContent> &
  ModalState & {
    onClose: () => void;
  };

function Modal({ component, componentProps, onClose, ...props }: ModalProps) {
  const [Component, setComponent] = useState<ComponentType<any> | null>(null);

  useEffect(() => {
    const load = async () => {
      const [vendorPath, componentPath] = component.includes("::")
        ? component.split("::")
        : [null, component];

      const pages = (() => {
        switch (vendorPath) {
          case "narsil/cms":
            return import.meta.glob("@narsil-cms/pages/**/*.tsx");
          default:
            return import.meta.glob("@/pages/**/*.tsx");
        }
      })();

      const loader =
        pages[
          vendorPath
            ? `/vendor/${vendorPath}/resources/js/pages/${componentPath}.tsx`
            : `/resources/js/pages/${componentPath}.tsx`
        ];

      if (!loader) {
        return onClose();
      }

      const mod = await (loader as () => Promise<any>)();

      setComponent(() => mod.default);
    };

    load();
  }, [component]);

  return (
    <Dialog open={true} onOpenChange={(open) => !open && onClose()}>
      <DialogContent
        className="absolute max-h-[calc(100%-4rem)] max-w-[calc(100%-4rem)] overflow-hidden"
        {...props}
      >
        <DialogHeader className="border-b">
          <DialogTitle>{componentProps.title}</DialogTitle>
        </DialogHeader>
        <VisuallyHidden asChild={true}>
          <DialogDescription>{componentProps.description}</DialogDescription>
        </VisuallyHidden>
        <LabelsProvider labels={componentProps.labels}>
          {Component ? <Component modal={true} {...componentProps} /> : null}
        </LabelsProvider>
      </DialogContent>
    </Dialog>
  );
}

export default Modal;
