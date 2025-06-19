import { cn } from "@/Components";
import { SubContent } from "@radix-ui/react-context-menu";

export type ContextMenuSubContentProps = React.ComponentProps<
  typeof SubContent
> & {};

function ContextMenuSubContent({
  className,
  ...props
}: ContextMenuSubContentProps) {
  return (
    <SubContent
      data-slot="context-menu-sub-content"
      className={cn(
        "bg-popover text-popover-foreground z-50 min-w-[8rem] overflow-hidden rounded-md border p-1 shadow-lg",
        "data-[side=bottom]:slide-in-from-top-2",
        "data-[side=left]:slide-in-from-right-2",
        "data-[side=right]:slide-in-from-left-2",
        "data-[side=top]:slide-in-from-bottom-2",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
        "data-[state=open]:animate-in data-[state=closed]:animate-out",
        "origin-(--radix-context-menu-content-transform-origin)",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuSubContent;
