import { Collapsible as CollapsiblePrimitive } from "radix-ui";

type CollapsibleContentProps = React.ComponentProps<
  typeof CollapsiblePrimitive.Content
> & {};

function CollapsibleContent({ ...props }: CollapsibleContentProps) {
  return (
    <CollapsiblePrimitive.Content data-slot="collapsible-content" {...props} />
  );
}

export default CollapsibleContent;
