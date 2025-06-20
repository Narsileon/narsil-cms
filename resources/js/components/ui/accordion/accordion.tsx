import { Root } from "@radix-ui/react-accordion";

export type AccordionProps = React.ComponentProps<typeof Root> & {};

function Accordion({ ...props }: AccordionProps) {
  return <Root data-slot="accordion" {...props} />;
}

export default Accordion;
