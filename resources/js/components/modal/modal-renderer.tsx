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
          onClose={() => closeModal(modal.linkProps.href as string)}
          key={modal.linkProps.href as string}
          {...props}
        />
      ))}
    </>
  );
}

export default ModalRenderer;
