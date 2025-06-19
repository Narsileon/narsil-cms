import { cn } from "@/Components";
import { Separator } from "@radix-ui/react-dropdown-menu";

export type DropdownMenuSeparatorProps = React.ComponentProps<
  typeof Separator
> & {};

function DropdownMenuSeparator({
  className,
  ...props
}: DropdownMenuSeparatorProps) {
  return (
    <Separator
      data-slot="dropdown-menu-separator"
      className={cn("bg-border -mx-1 my-1 h-px", className)}
      {...props}
    />
  );
}

export default DropdownMenuSeparator;
