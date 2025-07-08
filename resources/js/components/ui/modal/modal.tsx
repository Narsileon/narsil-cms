import { Dialog, DialogContent } from "@/components/ui/dialog";
import { useEffect, useState } from "react";

type ModalResponse = {
  component: string;
  props: Record<string, any>;
};

function Modal({
  href,
  open,
  onClose,
}: {
  href: string;
  open: boolean;
  onClose: () => void;
}) {
  const [Component, setComponent] = useState<React.ComponentType<any> | null>(
    null,
  );
  const [props, setProps] = useState<Record<string, any>>({});

  useEffect(() => {
    if (!open) return;

    const fetchModal = async () => {
      try {
        const url = new URL(href, window.location.origin);
        url.searchParams.set("modal", "1");

        const response = await fetch(url.toString(), {
          headers: {
            Accept: "application/json",
          },
        });

        if (!response.ok) {
          throw new Error("Modal fetch failed");
        }

        const data = (await response.json()) as ModalResponse;

        if (!!data.component) {
          throw new Error("Invalid modal response");
        }

        const pages = import.meta.glob("/resources/js/pages/**/*.tsx");

        const loader: any = pages[`/resources/js/pages/${data.component}.tsx`];

        const mod = await loader();
        setComponent(() => mod.default);
        setProps(data.props);
      } catch (err) {
        console.error("Modal loading error:", err);
        onClose();
      }
    };

    fetchModal();
  }, [href, open]);

  return (
    <Dialog open={open} onOpenChange={(open) => !open && onClose()}>
      <DialogContent className="max-w-2xl p-6">
        {Component && <Component {...props} />}
      </DialogContent>
    </Dialog>
  );
}

export default Modal;
