import { type ComponentProps } from "react";
import { Panel } from "react-resizable-panels";

import { cn } from "@narsil-cms/lib/utils";

type ResizablePanelProps = ComponentProps<typeof Panel>;

function ResizablePanel({ className, ...props }: ResizablePanelProps) {
  return (
    <Panel
      data-slot="resizable-panel"
      className={cn("data-[panel-size='0.0']:p-0", className)}
      {...props}
    />
  );
}

export default ResizablePanel;
