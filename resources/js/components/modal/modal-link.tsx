import { Link } from "@inertiajs/react";
import { DialogContent } from "@narsil-cms/components/dialog";
import { useModalStore } from "@narsil-cms/stores/modal-store";
import { type ComponentProps } from "react";

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

  return (
    <Comp
      data-slot="modal-link"
      aria-haspopup="dialog"
      type="button"
      onClick={handleClick}
      {...props}
    />
  );
}

export default ModalLink;
