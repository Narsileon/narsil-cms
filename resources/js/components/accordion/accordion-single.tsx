import { Accordion } from "radix-ui";

type AccordionSingleProps = Accordion.AccordionSingleProps & {};

function AccordionSingle({
  collapsible = true,
  type = "single",
  ...props
}: AccordionSingleProps) {
  return (
    <Accordion.Root
      data-slot="accordion-root"
      collapsible={collapsible}
      type={type}
      {...props}
    />
  );
}

export default AccordionSingle;
