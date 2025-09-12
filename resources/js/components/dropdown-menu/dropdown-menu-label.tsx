import { cn } from "@narsil-cms/lib/utils";
import { DropdownMenu as DropdownMenuPrimitive } from "radix-ui";

type DropdownMenuLabelProps = React.ComponentProps<
  typeof DropdownMenuPrimitive.Label
> & {
  inset?: boolean;
};

function DropdownMenuLabel({
  className,
  inset,
  ...props
}: DropdownMenuLabelProps) {
  return (
    <DropdownMenuPrimitive.Label
      data-slot="dropdown-menu-label"
      data-inset={inset}
      className={cn(
        "px-2 py-1.5 text-sm font-medium",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuLabel;
