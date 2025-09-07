import * as React from "react";
import { Slot as SlotPrimitive } from "radix-ui";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import type { VisitCallbacks } from "@inertiajs/core";

type ModalLinkProps = React.ComponentProps<"button"> & {
  asChild?: boolean;
  href: string;
  options?: Partial<VisitCallbacks>;
};

function ModalLink({
  asChild = false,
  href,
  options,
  onClick,
  ...props
}: ModalLinkProps) {
  const { openModal } = useModalStore();

  const Comp = asChild ? SlotPrimitive.Slot : "button";

  function handleClick(event: React.MouseEvent<HTMLButtonElement>) {
    onClick?.(event);
    openModal(href, options);
  }

  return (
    <Comp
      data-slot="modal-link"
      aria-haspopup="dialog"
      onClick={handleClick}
      {...props}
    />
  );
}

export default ModalLink;
