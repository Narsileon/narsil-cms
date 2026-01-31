import { Menu } from "@base-ui/react/menu";
import { cn } from "@narsil-cms/lib/utils";

function MenubarSeparator({ className, ...props }: Menu.Separator.Props) {
  return (
    <Menu.Separator
      data-slot="menubar-separator"
      className={cn("-mx-1 my-1 h-px bg-border", className)}
      {...props}
    />
  );
}

export default MenubarSeparator;
