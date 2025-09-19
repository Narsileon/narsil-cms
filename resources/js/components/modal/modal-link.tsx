import { Link } from "@inertiajs/react";

import { useModalStore } from "@narsil-cms/stores/modal-store";

type ModalLinkProps = React.ComponentProps<typeof Link> & {};

function ModalLink({ as = "button", onClick, ...props }: ModalLinkProps) {
  const { openModal } = useModalStore();

  const Comp = as;

  function handleClick(event: React.MouseEvent<HTMLButtonElement>) {
    onClick?.(event);
    openModal({ ...props });
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
