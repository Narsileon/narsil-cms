import { CollapsibleContent as Content } from "@radix-ui/react-collapsible";

export type CollapsibleContentProps = React.ComponentProps<typeof Content> & {};

function CollapsibleContent({ ...props }: CollapsibleContentProps) {
  return <Content data-slot="collapsible-content" {...props} />;
}

export default CollapsibleContent;
