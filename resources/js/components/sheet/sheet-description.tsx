import { cn } from "@narsil-cms/lib/utils";
import { Dialog as SheetPrimitive } from "radix-ui";

type SheetDescriptionProps = React.ComponentProps<
  typeof SheetPrimitive.Description
> & {};

function SheetDescription({ className, ...props }: SheetDescriptionProps) {
  return (
    <SheetPrimitive.Description
      data-slot="sheet-description"
      className={cn("text-sm text-muted-foreground", className)}
      {...props}
    />
  );
}

export default SheetDescription;
