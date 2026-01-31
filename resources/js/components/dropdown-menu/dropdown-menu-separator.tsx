import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function DropdownMenuSeparator({ className, ...props }: Menu.Separator.Props) {
  return (
    <Menu.Separator
      data-slot="dropdown-menu-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default DropdownMenuSeparator;
