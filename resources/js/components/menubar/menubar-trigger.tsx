import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function MenubarTrigger({ className, ...props }: Menu.Trigger.Props) {
  return (
    <Menu.Trigger
      data-slot="menubar-trigger"
      className={cn(
        "flex cursor-pointer items-center rounded-sm px-1.5 py-0.5 text-sm font-medium outline-hidden select-none",
        "hover:bg-muted",
        "aria-expanded:bg-muted",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarTrigger;
