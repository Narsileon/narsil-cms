import { cn } from "@narsil-cms/lib/utils";

type ShortcutRootProps = React.ComponentProps<"span"> & {};

function ShortcutRoot({ className, ...props }: ShortcutRootProps) {
  return (
    <span
      data-slot="shortcut-root"
      className={cn(
        "ml-auto text-xs tracking-widest text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default ShortcutRoot;
