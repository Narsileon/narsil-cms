import { VisuallyHidden } from "@narsil-cms/blocks/visually-hidden";
import {
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogOverlay,
  DialogPortal,
  DialogRoot,
  DialogTitle,
} from "@narsil-cms/components/dialog";
import { LocalizationProvider } from "@narsil-cms/components/localization";
import { type ModalType } from "@narsil-cms/stores/modal-store";
import { useEffect, useState, type ComponentProps, type ReactNode } from "react";

type ModalProps = ComponentProps<typeof DialogContent> & {
  modal: ModalType;
  onClose: () => void;
};

function Modal({ modal, onClose, ...props }: ModalProps) {
  const [Component, setComponent] = useState<ReactNode>(null);

  useEffect(() => {
    const load = async () => {
      const [vendorPath, componentPath] = modal.component.includes("::")
        ? modal.component.split("::")
        : [null, modal.component];

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
  }, [modal.component]);

  return (
    <DialogRoot open={true} onOpenChange={(open) => !open && onClose()}>
      <DialogPortal>
        <DialogOverlay />
        <DialogContent className="overflow-hidden" variant={modal.variant} {...props}>
          <DialogHeader className="border-b">
            <DialogTitle>{modal.componentProps.title}</DialogTitle>
          </DialogHeader>
          <VisuallyHidden asChild={true}>
            <DialogDescription>{modal.componentProps.description}</DialogDescription>
          </VisuallyHidden>

          <LocalizationProvider translations={modal.componentProps.translations}>
            <DialogBody className="p-0">
              {Component ? <Component modal={modal} {...modal.componentProps} /> : null}
            </DialogBody>
          </LocalizationProvider>
        </DialogContent>
      </DialogPortal>
    </DialogRoot>
  );
}

export default Modal;
