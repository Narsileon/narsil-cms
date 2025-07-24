import { cn } from "@narsil-cms/lib/utils";
import { Dialog as SheetPrimitive } from "radix-ui";

type SheetOverlayProps = React.ComponentProps<
  typeof SheetPrimitive.Overlay
> & {};

function SheetOverlay({ className, ...props }: SheetOverlayProps) {
  return (
    <SheetPrimitive.Overlay
      data-slot="sheet-overlay"
      className={cn(
        "fixed inset-0 z-50 bg-black/50",
        "data-[state=open]:animate-in data-[state=closed]:animate-out",
        "data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0",
        className,
      )}
      {...props}
    />
  );
}

export default SheetOverlay;
