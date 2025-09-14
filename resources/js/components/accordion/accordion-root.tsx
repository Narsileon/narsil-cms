import { Accordion } from "radix-ui";

type AccordionRootProps = React.ComponentProps<typeof Accordion.Root> & {};

function AccordionRoot({ ...props }: AccordionRootProps) {
  return <Accordion.Root data-slot="accordion-root" {...props} />;
}

export default AccordionRoot;
