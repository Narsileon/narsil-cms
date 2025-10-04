import { Accordion } from "radix-ui";
import { type ComponentProps } from "react";

type AccordionRootProps = ComponentProps<typeof Accordion.Root>;

function AccordionRoot({ ...props }: AccordionRootProps) {
  return <Accordion.Root data-slot="accordion-root" {...props} />;
}

export default AccordionRoot;
