import { useModalStore } from "@narsil-cms/stores/modal-store";
import Modal from "./modal";

type ModalRendererProps = Pick<
  React.ComponentProps<typeof Modal>,
  "container"
> & {};

function ModalRenderer({ ...props }: ModalRendererProps) {
  const { modals, closeModal } = useModalStore();

  return (
    <>
      {modals.map((modal) => (
        <Modal
          modal={modal}
          onClose={() => closeModal(modal.href)}
          key={modal.href}
          {...props}
        />
      ))}
    </>
  );
}

export default ModalRenderer;
