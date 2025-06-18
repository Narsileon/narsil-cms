import { Root } from "@radix-ui/react-collapsible";

export type CollapsibleProps = React.ComponentProps<typeof Root> & {};

function Collapsible({ ...props }: CollapsibleProps) {
  return <Root data-slot="collapsible" {...props} />;
}

export default Collapsible;
