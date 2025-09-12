import { Accordion as AccordionPrimitive } from "radix-ui";

type AccordionRootProps = React.ComponentProps<
  typeof AccordionPrimitive.Root
> & {};

function AccordionRoot({ ...props }: AccordionRootProps) {
  return <AccordionPrimitive.Root data-slot="accordion-root" {...props} />;
}

export default AccordionRoot;
