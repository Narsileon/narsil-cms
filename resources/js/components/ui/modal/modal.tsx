import { Dialog, DialogContent } from "@/components/ui/dialog";
import { ModalState } from "@/stores/modal-store";
import { useEffect, useState } from "react";
import type { ComponentProps, ComponentType } from "react";

type ModalProps = ComponentProps<typeof Dialog> &
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
    <Dialog open={true} onOpenChange={(open) => !open && onClose()} {...props}>
      <DialogContent className="max-w-2xl p-6">
        {Component ? <Component modal={true} {...componentProps} /> : null}
      </DialogContent>
    </Dialog>
  );
}

export default Modal;
