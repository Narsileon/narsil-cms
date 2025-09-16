import {
  ScrollAreaCorner,
  ScrollAreaRoot,
  ScrollAreaScrollbar,
  ScrollAreaThumb,
  ScrollAreaViewport,
} from "@narsil-cms/components/scroll-area";

type ScrollAreaProps = React.ComponentProps<typeof ScrollAreaRoot> & {
  cornerProps?: Partial<React.ComponentProps<typeof ScrollAreaCorner>>;
  scrollbarProps?: Partial<React.ComponentProps<typeof ScrollAreaScrollbar>>;
  thumbProps?: Partial<React.ComponentProps<typeof ScrollAreaThumb>>;
  viewportProps?: Partial<React.ComponentProps<typeof ScrollAreaViewport>>;
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
