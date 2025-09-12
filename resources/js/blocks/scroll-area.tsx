import { ScrollArea as ScrollAreaPrimitive } from "radix-ui";

import {
  ScrollAreaRoot,
  ScrollAreaScrollbar,
  ScrollAreaThumb,
  ScrollAreaViewport,
} from "@narsil-cms/components/scroll-area";

type ScrollAreaProps = React.ComponentProps<typeof ScrollAreaViewport> & {
  orientation?: React.ComponentProps<typeof ScrollAreaScrollbar>["orientation"];
};

const ScrollArea = ({
  children,
  orientation = "vertical",
  ...props
}: ScrollAreaProps) => {
  return (
    <ScrollAreaRoot>
      <ScrollAreaViewport {...props}>{children}</ScrollAreaViewport>
      <ScrollAreaScrollbar orientation={orientation}>
        <ScrollAreaThumb />
      </ScrollAreaScrollbar>
      <ScrollAreaPrimitive.Corner />
    </ScrollAreaRoot>
  );
};

export default ScrollArea;
