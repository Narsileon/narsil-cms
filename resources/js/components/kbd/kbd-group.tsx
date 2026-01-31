import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function KbdGroup({ className, ...props }: ComponentProps<"div">) {
  return (
    <kbd
      data-slot="kbd-group"
      className={cn("inline-flex items-center gap-1", className)}
      {...props}
    />
  );
}
export default KbdGroup;
