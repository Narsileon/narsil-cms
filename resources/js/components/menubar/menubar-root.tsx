import { Menubar } from "@base-ui/react/menubar";
import { cn } from "@narsil-cms/lib/utils";

function MenubarRoot({ className, ...props }: Menubar.Props) {
  return (
    <Menubar
      data-slot="menubar-root"
      className={cn(
        "flex h-8 items-center gap-0.5 rounded-lg border bg-background p-0.75",
        className,
      )}
      {...props}
    />
  );
}

export default MenubarRoot;
