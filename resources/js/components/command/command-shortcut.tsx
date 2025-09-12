import { cn } from "@narsil-cms/lib/utils";

type CommandShortcutProps = React.ComponentProps<"span"> & {};

function CommandShortcut({ className, ...props }: CommandShortcutProps) {
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

export default CommandShortcut;
