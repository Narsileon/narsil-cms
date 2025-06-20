import { cn } from "@/components";
import { Root } from "@radix-ui/react-menubar";

export type MenubarProps = React.ComponentProps<typeof Root> & {};

function Menubar({ className, ...props }: MenubarProps) {
  return (
    <Root
      data-slot="menubar"
      className={cn(
        "bg-background flex h-9 items-center gap-1 rounded-md border p-1 shadow-xs",
        className,
      )}
      {...props}
    />
  );
}

export default Menubar;
