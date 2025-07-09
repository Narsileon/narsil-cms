import { useModalStore } from "@/stores/modal-store";
import Modal from "./modal";

type ModalRendererProps = {};

function ModalRenderer({}: ModalRendererProps) {
  const { modals, closeModal } = useModalStore();

  return (
    <>
      {modals.map((modal) => (
        <Modal
          component={modal.component}
          componentProps={modal.componentProps}
          href={modal.href}
          onClose={() => closeModal(modal.href)}
          key={modal.href}
        />
      ))}
    </>
  );
}

export default ModalRenderer;
