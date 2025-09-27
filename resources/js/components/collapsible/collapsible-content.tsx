import { Collapsible } from "radix-ui";
import { type ComponentProps } from "react";

type CollapsibleContentProps = ComponentProps<typeof Collapsible.Content> & {};

function CollapsibleContent({ ...props }: CollapsibleContentProps) {
  return <Collapsible.Content data-slot="collapsible-content" {...props} />;
}

export default CollapsibleContent;
