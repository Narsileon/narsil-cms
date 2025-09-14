import { ScrollArea } from "radix-ui";

type ScrollAreaCornerProps = React.ComponentProps<
  typeof ScrollArea.Corner
> & {};

const ScrollAreaCorner = ({ ...props }: ScrollAreaCornerProps) => {
  return <ScrollArea.Corner data-slot="scroll-area-corner" {...props} />;
};

export default ScrollAreaCorner;
