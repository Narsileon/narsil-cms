import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function DropdownMenuTrigger({ className, ...props }: Menu.Trigger.Props) {
  return (
    <Menu.Trigger
      data-slot="dropdown-menu-trigger"
      className={cn("cursor-pointer", className)}
      {...props}
    />
  );
}

export default DropdownMenuTrigger;
