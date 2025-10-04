import { ScrollArea } from "radix-ui";
import { type ComponentProps } from "react";

type ScrollAreaCornerProps = ComponentProps<typeof ScrollArea.Corner>;

const ScrollAreaCorner = ({ ...props }: ScrollAreaCornerProps) => {
  return <ScrollArea.Corner data-slot="scroll-area-corner" {...props} />;
};

export default ScrollAreaCorner;
