import { type ComponentProps } from "react";
import { PanelResizeHandle } from "react-resizable-panels";

import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";
import { type IconName } from "@narsil-cms/plugins/icons";

type ResizableHandleProps = ComponentProps<typeof PanelResizeHandle> & {
  icon?: IconName | null;
};

function ResizableHandle({
  className,
  icon = "grip-vertical",
  ...props
}: ResizableHandleProps) {
  return (
    <PanelResizeHandle
      data-slot="resizable-handle"
      className={cn(
        "relative flex w-px items-center justify-center bg-border",
        "after:absolute after:inset-y-0 after:left-1/2 after:w-1 after:-translate-x-1/2",
        "focus-visible:ring-1 focus-visible:ring-offset-1 focus-visible:outline-hidden",
        "focus-visible:ring-ring",
        "data-[panel-group-direction=vertical]:after:left-0 data-[panel-group-direction=vertical]:after:h-1 data-[panel-group-direction=vertical]:after:w-full data-[panel-group-direction=vertical]:after:translate-x-0 data-[panel-group-direction=vertical]:after:-translate-y-1/2",
        "data-[panel-group-direction=vertical]:h-px data-[panel-group-direction=vertical]:w-full",
        "[&[data-panel-group-direction=vertical]>div]:rotate-90",
        className,
      )}
      {...props}
    >
      {icon && (
        <div className="z-10 flex h-4 w-3 items-center justify-center rounded-md border bg-border">
          <Icon className="size-2.5" name={icon} />
        </div>
      )}
    </PanelResizeHandle>
  );
}

export default ResizableHandle;
