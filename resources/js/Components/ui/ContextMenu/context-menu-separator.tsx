import { cn } from "@/Components";
import { Separator } from "@radix-ui/react-context-menu";

export type ContextMenuSeparatorProps = React.ComponentProps<
  typeof Separator
> & {};

function ContextMenuSeparator({
  className,
  ...props
}: ContextMenuSeparatorProps) {
  return (
    <Separator
      data-slot="context-menu-separator"
      className={cn("bg-border -mx-1 my-1 h-px", className)}
      {...props}
    />
  );
}

export default ContextMenuSeparator;
