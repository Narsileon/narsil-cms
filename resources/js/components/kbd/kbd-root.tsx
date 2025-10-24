import { cn } from "@narsil-cms/lib/utils";

type KbdRootProps = React.ComponentProps<"kbd">;

function KbdRoot({ className, ...props }: KbdRootProps) {
  return (
    <kbd
      data-slot="kbd-root"
      className={cn(
        "pointer-events-none inline-flex h-5 w-fit min-w-5 items-center justify-center gap-1 rounded-sm bg-muted px-1 text-xs font-medium text-muted-foreground select-none",
        "[&_svg:not([class*='size-'])]:size-3",
        className,
      )}
      {...props}
    />
  );
}

export default KbdRoot;
