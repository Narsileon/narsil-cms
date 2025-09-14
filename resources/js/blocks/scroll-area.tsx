import { ScrollArea } from "radix-ui";

import {
  ScrollAreaRoot,
  ScrollAreaScrollbar,
  ScrollAreaThumb,
  ScrollAreaViewport,
} from "@narsil-cms/components/scroll-area";

type ScrollAreaProps = React.ComponentProps<typeof ScrollAreaRoot> & {
  orientation?: React.ComponentProps<typeof ScrollAreaScrollbar>["orientation"];
};

const ScrollArea = ({
  asChild = false,
  children,
  orientation = "vertical",
  ...props
}: ScrollAreaProps) => {
  return (
    <ScrollAreaRoot {...props}>
      <ScrollAreaViewport asChild={asChild}>{children}</ScrollAreaViewport>
      <ScrollAreaScrollbar orientation={orientation}>
        <ScrollAreaThumb />
      </ScrollAreaScrollbar>
      <ScrollArea.Corner />
    </ScrollAreaRoot>
  );
};

export default ScrollArea;
