import { cn } from "@narsil-cms/lib/utils";

type ShortcutProps = React.ComponentProps<"span"> & {};

function Shortcut({ className, ...props }: ShortcutProps) {
  return (
    <span
      data-slot="command-shortcut"
      className={cn(
        "ml-auto text-xs tracking-widest text-muted-foreground",
        className,
      )}
      {...props}
    />
  );
}

export default Shortcut;
