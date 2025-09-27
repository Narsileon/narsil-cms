import { type ComponentProps } from "react";

import {
  ScrollAreaCorner,
  ScrollAreaRoot,
  ScrollAreaScrollbar,
  ScrollAreaThumb,
  ScrollAreaViewport,
} from "@narsil-cms/components/scroll-area";

type ScrollAreaProps = ComponentProps<typeof ScrollAreaRoot> & {
  cornerProps?: Partial<ComponentProps<typeof ScrollAreaCorner>>;
  scrollbarProps?: Partial<ComponentProps<typeof ScrollAreaScrollbar>>;
  thumbProps?: Partial<ComponentProps<typeof ScrollAreaThumb>>;
  viewportProps?: Partial<ComponentProps<typeof ScrollAreaViewport>>;
};

const ScrollArea = ({
  children,
  cornerProps,
  scrollbarProps,
  thumbProps,
  viewportProps,
  ...props
}: ScrollAreaProps) => {
  return (
    <ScrollAreaRoot {...props}>
      <ScrollAreaViewport {...viewportProps}>{children}</ScrollAreaViewport>
      <ScrollAreaScrollbar {...scrollbarProps}>
        <ScrollAreaThumb {...thumbProps} />
      </ScrollAreaScrollbar>
      <ScrollAreaCorner {...cornerProps} />
    </ScrollAreaRoot>
  );
};

export default ScrollArea;
