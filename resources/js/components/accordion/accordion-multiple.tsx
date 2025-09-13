import { Accordion } from "radix-ui";

type AccordionMultipleProps = Accordion.AccordionMultipleProps & {};

function AccordionMultiple({
  type = "multiple",
  ...props
}: AccordionMultipleProps) {
  return <Accordion.Root data-slot="accordion-root" type={type} {...props} />;
}

export default AccordionMultiple;
