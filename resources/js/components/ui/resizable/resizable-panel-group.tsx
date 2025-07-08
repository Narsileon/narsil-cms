import { cn } from "@/lib/utils";
import { PanelGroup } from "react-resizable-panels";

type ResizablePanelGroupProps = React.ComponentProps<typeof PanelGroup> & {};

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
