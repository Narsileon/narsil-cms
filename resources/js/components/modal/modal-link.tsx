import { Link } from "@inertiajs/react";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { type ComponentProps } from "react";
import { DialogContent } from "../dialog";

type ModalLinkProps = ComponentProps<typeof Link> & {
  variant?: ComponentProps<typeof DialogContent>["variant"];
};

function ModalLink({ as = "button", variant = "default", onClick, ...props }: ModalLinkProps) {
  const { openModal } = useModalStore();

  const Comp = as;

  function handleClick(event: React.MouseEvent<HTMLButtonElement>) {
    onClick?.(event);
    openModal({ ...props }, variant);
  }

  return <Comp data-slot="modal-link" aria-haspopup="dialog" onClick={handleClick} {...props} />;
}

export default ModalLink;
