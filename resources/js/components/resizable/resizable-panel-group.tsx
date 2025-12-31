import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";
import { Group } from "react-resizable-panels";

type ResizablePanelGroupProps = ComponentProps<typeof Group>;

function ResizablePanelGroup({ className, ...props }: ResizablePanelGroupProps) {
  return (
    <Group
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
