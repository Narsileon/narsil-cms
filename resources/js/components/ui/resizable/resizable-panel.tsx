import { cn } from "@/lib/utils";
import { Panel } from "react-resizable-panels";

type ResizablePanelProps = React.ComponentProps<typeof Panel> & {};

function ResizablePanel({ className, ...props }: ResizablePanelProps) {
  return (
    <Panel
      className={cn("data-[panel-size='0.0']:p-0", className)}
      data-slot="resizable-panel"
      {...props}
    />
  );
}

export default ResizablePanel;
