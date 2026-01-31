import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

type MenubarGroupLabelProps = Menu.GroupLabel.Props & {
  inset?: boolean;
};

function MenubarGroupLabel({ className, inset, ...props }: MenubarGroupLabelProps) {
  return (
    <Menu.GroupLabel
      data-slot="menubar-label"
      data-inset={inset}
      className={cn(
        "px-1.5 py-1 text-sm font-medium text-muted-foreground",
        "data-inset:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarGroupLabel;
