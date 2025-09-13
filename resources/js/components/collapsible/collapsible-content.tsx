import { Collapsible } from "radix-ui";

type CollapsibleContentProps = React.ComponentProps<
  typeof Collapsible.Content
> & {};

function CollapsibleContent({ ...props }: CollapsibleContentProps) {
  return <Collapsible.Content data-slot="collapsible-content" {...props} />;
}

export default CollapsibleContent;
