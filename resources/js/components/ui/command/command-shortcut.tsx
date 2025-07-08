import { cn } from "@/lib/utils";

type CommandShortcutProps = React.ComponentProps<"span"> & {};

function CommandShortcut({ className, ...props }: CommandShortcutProps) {
  return (
    <span
      data-slot="command-shortcut"
      className={cn(
        "text-muted-foreground ml-auto text-xs tracking-widest",
        className,
      )}
      {...props}
    />
  );
}

export default CommandShortcut;
