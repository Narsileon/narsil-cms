import { cn } from "@/components";
import { Dialog as SheetPrimitive } from "radix-ui";

export type SheetDescriptionProps = React.ComponentProps<
  typeof SheetPrimitive.Description
> & {};

function SheetDescription({ className, ...props }: SheetDescriptionProps) {
  return (
    <SheetPrimitive.Description
      data-slot="sheet-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default SheetDescription;
