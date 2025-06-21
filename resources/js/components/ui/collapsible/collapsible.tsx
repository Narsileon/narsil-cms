import { Collapsible as CollapsiblePrimitive } from "radix-ui";

export type CollapsibleProps = React.ComponentProps<
  typeof CollapsiblePrimitive.Root
> & {};

function Collapsible({ ...props }: CollapsibleProps) {
  return <CollapsiblePrimitive.Root data-slot="collapsible" {...props} />;
}

export default Collapsible;
