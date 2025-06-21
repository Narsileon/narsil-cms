import { Accordion as AccordionPrimitive } from "radix-ui";

export type AccordionProps = React.ComponentProps<
  typeof AccordionPrimitive.Root
> & {};

function Accordion({ ...props }: AccordionProps) {
  return <AccordionPrimitive.Root data-slot="accordion" {...props} />;
}

export default Accordion;
