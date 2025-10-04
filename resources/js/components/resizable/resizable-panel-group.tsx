import { type ComponentProps } from "react";
import { PanelGroup } from "react-resizable-panels";

import { cn } from "@narsil-cms/lib/utils";

type ResizablePanelGroupProps = ComponentProps<typeof PanelGroup>;

function ResizablePanelGroup({
  className,
  ...props
}: ResizablePanelGroupProps) {
  return (
    <PanelGroup
      data-slot="resizable-panel-group"
      className={cn(
        "flex h-full w-full",
        "data-[panel-group-direction=vertical]:flex-col",
        className,
      )}
      {...props}
    />
  );
}

export default ResizablePanelGroup;
