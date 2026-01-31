import { ScrollArea } from "@base-ui/react/scroll-area";

function ScrollAreaCorner({ ...props }: ScrollArea.Corner.Props) {
  return <ScrollArea.Corner data-slot="scroll-area-corner" {...props} />;
}

export default ScrollAreaCorner;
