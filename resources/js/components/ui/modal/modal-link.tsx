import { Slot as SlotPrimitive } from "radix-ui";
import { useModalStore } from "@narsil-cms/stores/modal-store";

type ModalLinkProps = React.ComponentProps<"button"> & {
  asChild?: boolean;
  href: string;
};

function ModalLink({
  asChild = false,
  href,
  onClick,
  ...props
}: ModalLinkProps) {
  const { openModal } = useModalStore();

  const Comp = asChild ? SlotPrimitive.Slot : "button";

  function handleClick(event: React.MouseEvent<HTMLButtonElement>) {
    onClick?.(event);
    openModal(href);
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
