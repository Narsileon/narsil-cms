import {
  ScrollAreaCorner,
  ScrollAreaRoot,
  ScrollAreaScrollbar,
  ScrollAreaThumb,
  ScrollAreaViewport,
} from "@narsil-cms/components/scroll-area";
import { type ComponentProps } from "react";

function ScrollArea({ children, ...props }: ComponentProps<typeof ScrollAreaRoot>) {
  return (
    <ScrollAreaRoot {...props}>
      <ScrollAreaViewport>{children}</ScrollAreaViewport>
      <ScrollAreaScrollbar>
        <ScrollAreaThumb />
      </ScrollAreaScrollbar>
      <ScrollAreaCorner />
    </ScrollAreaRoot>
  );
}

export default ScrollArea;
