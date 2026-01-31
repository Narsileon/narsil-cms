import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

type DropdownMenuGroupLabelProps = Menu.GroupLabel.Props & {
  inset?: boolean;
};

function DropdownMenuGroupLabel({ className, inset, ...props }: DropdownMenuGroupLabelProps) {
  return (
    <Menu.GroupLabel
      data-slot="dropdown-menu-group-label"
      data-inset={inset}
      className={cn(
        "px-1.5 py-1 text-xs font-medium text-muted-foreground",
        "data-inset:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default DropdownMenuGroupLabel;
