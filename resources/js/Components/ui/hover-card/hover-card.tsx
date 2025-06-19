import { Root } from "@radix-ui/react-hover-card";

export type HoverCardProps = React.ComponentProps<typeof Root> & {};

function HoverCard({ ...props }: HoverCardProps) {
  return <Root data-slot="hover-card" {...props} />;
}

export default HoverCard;
