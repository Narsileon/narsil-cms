import { Dialog, DialogContent } from "@/components/ui/dialog";
import { LabelsProvider } from "@/components/ui/labels";
import { ModalState } from "@/stores/modal-store";
import { useEffect, useState } from "react";
import type { ComponentProps, ComponentType } from "react";

type ModalProps = ComponentProps<typeof DialogContent> &
  ModalState & {
    onClose: () => void;
  };

function Modal({ component, componentProps, onClose, ...props }: ModalProps) {
  const [Component, setComponent] = useState<ComponentType<any> | null>(null);

  useEffect(() => {
    const load = async () => {
      const pages = import.meta.glob("/resources/js/pages/**/*.tsx");

      const loader = pages[`/resources/js/pages/${component}.tsx`];

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
        className="absolute h-[calc(100%-4rem)] min-w-[calc(100%-4rem)]"
        {...props}
      >
        <LabelsProvider labels={componentProps.labels}>
          {Component ? <Component modal={true} {...componentProps} /> : null}
        </LabelsProvider>
      </DialogContent>
    </Dialog>
  );
}

export default Modal;
