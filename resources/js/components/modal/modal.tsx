import { useEffect, useState } from "react";

import {
  DialogBody,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogRoot,
  DialogTitle,
} from "@narsil-cms/components/dialog";
import { LabelsProvider } from "@narsil-cms/components/labels";
import { VisuallyHiddenRoot } from "@narsil-cms/components/visually-hidden";
import { type ModalType } from "@narsil-cms/stores/modal-store";

type ModalProps = React.ComponentProps<typeof DialogContent> & {
  modal: ModalType;
  onClose: () => void;
};

function Modal({ modal, onClose, ...props }: ModalProps) {
  const [Component, setComponent] = useState<React.ReactNode | null>(null);

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
      <DialogContent
        className="max-h-[calc(100%-13rem)] max-w-[calc(100%-4rem)] overflow-hidden"
        {...props}
      >
        <DialogHeader className="border-b">
          <DialogTitle>{modal.componentProps.title}</DialogTitle>
        </DialogHeader>
        <VisuallyHiddenRoot asChild={true}>
          <DialogDescription>
            {modal.componentProps.description}
          </DialogDescription>
        </VisuallyHiddenRoot>

        <LabelsProvider labels={modal.componentProps.labels}>
          <DialogBody className="p-0">
            {Component ? (
              <Component modal={modal} {...modal.componentProps} />
            ) : null}
          </DialogBody>
        </LabelsProvider>
      </DialogContent>
    </DialogRoot>
  );
}

export default Modal;
