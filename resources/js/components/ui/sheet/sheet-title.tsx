import { cn } from "@/components";
import { Dialog as SheetPrimitive } from "radix-ui";

export type SheetTitleProps = React.ComponentProps<
  typeof SheetPrimitive.Title
> & {};

function SheetTitle({ className, ...props }: SheetTitleProps) {
  return (
    <SheetPrimitive.Title
      data-slot="sheet-title"
      className={cn("text-foreground font-semibold", className)}
      {...props}
    />
  );
}

export default SheetTitle;
