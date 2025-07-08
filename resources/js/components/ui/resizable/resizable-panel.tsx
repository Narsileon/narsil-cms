import { Panel } from "react-resizable-panels";

type ResizablePanelProps = React.ComponentProps<typeof Panel> & {};

function ResizablePanel({ ...props }: ResizablePanelProps) {
  return <Panel data-slot="resizable-panel" {...props} />;
}

export default ResizablePanel;
