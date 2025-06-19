import { cn } from "@/Components";
import { Label } from "@radix-ui/react-context-menu";

export type ContextMenuLabelProps = React.ComponentProps<typeof Label> & {
  inset?: boolean;
};

function ContextMenuLabel({
  className,
  inset,
  ...props
}: ContextMenuLabelProps) {
  return (
    <Label
      data-slot="context-menu-label"
      data-inset={inset}
      className={cn(
        "text-foreground px-2 py-1.5 text-sm font-medium",
        "data-[inset]:pl-8",
        className,
      )}
      {...props}
    />
  );
}

export default ContextMenuLabel;
