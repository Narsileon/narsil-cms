import { cn } from "@narsil-cms/lib/utils";

type KbdRootProps = React.ComponentProps<"kbd">;

function KbdRoot({ className, ...props }: KbdRootProps) {
  return (
    <kbd
      data-slot="kbd-root"
      className={cn(
        "bg-muted text-muted-foreground pointer-events-none inline-flex h-5 w-fit min-w-5 select-none items-center justify-center gap-1 rounded-sm px-1 font-sans text-xs font-medium",
        "[&_svg:not([class*='size-'])]:size-3",
        "[[data-slot=tooltip-content]_&]:bg-background/20 [[data-slot=tooltip-content]_&]:text-background dark:[[data-slot=tooltip-content]_&]:bg-background/10",
        className,
      )}
      {...props}
    />
  );
}

export default KbdRoot;
