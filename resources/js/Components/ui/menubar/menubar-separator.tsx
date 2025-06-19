import { cn } from "@/Components";
import { Separator } from "@radix-ui/react-menubar";

export type MenubarSeparatorProps = React.ComponentProps<typeof Separator> & {};

function MenubarSeparator({ className, ...props }: MenubarSeparatorProps) {
  return (
    <Separator
      data-slot="menubar-separator"
      className={cn("bg-border -mx-1 my-1 h-px", className)}
      {...props}
    />
  );
}

export default MenubarSeparator;
