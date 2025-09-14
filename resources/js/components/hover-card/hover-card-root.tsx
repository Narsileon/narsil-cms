import { HoverCard } from "radix-ui";

type HoverCardRootProps = React.ComponentProps<typeof HoverCard.Root> & {};

function HoverCardRoot({ ...props }: HoverCardRootProps) {
  return <HoverCard.Root data-slot="hover-card-root" {...props} />;
}

export default HoverCardRoot;
