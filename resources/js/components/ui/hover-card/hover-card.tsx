import { HoverCard as HoverCardPrimitive } from "radix-ui";

export type HoverCardProps = React.ComponentProps<
  typeof HoverCardPrimitive.Root
> & {};

function HoverCard({ ...props }: HoverCardProps) {
  return <HoverCardPrimitive.Root data-slot="hover-card" {...props} />;
}

export default HoverCard;
