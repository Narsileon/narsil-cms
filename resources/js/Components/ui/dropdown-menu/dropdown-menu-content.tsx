import { cn } from "@/Components";
import { Content, Portal } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuContentProps = React.ComponentProps<
  typeof Content
> & {};

function DropdownMenuContent({
  className,
  sideOffset = 4,
  ...props
}: DropdownMenuContentProps) {
  return (
    <Portal>
      <Content
        data-slot="dropdown-menu-content"
        className={cn(
          "bg-popover text-popover-foreground min-w-[8rem] overflow-x-hidden overflow-y-auto rounded-md border p-1 shadow-md",
          "data-[side=bottom]:slide-in-from-top-2",
          "data-[side=left]:slide-in-from-right-2",
          "data-[side=right]:slide-in-from-left-2",
          "data-[side=top]:slide-in-from-bottom-2 z-50",
          "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
          "data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95",
          "data-[state=open]:animate-in data-[state=closed]:animate-out",
          "max-h-(--radix-dropdown-menu-content-available-height)",
          "origin-(--radix-dropdown-menu-content-transform-origin)",
          className,
        )}
        sideOffset={sideOffset}
        {...props}
      />
    </Portal>
  );
}

export default DropdownMenuContent;
