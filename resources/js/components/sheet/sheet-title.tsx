import { Dialog as SheetPrimitive } from "radix-ui";

import { cn } from "@narsil-cms/lib/utils";

type SheetTitleProps = React.ComponentProps<typeof SheetPrimitive.Title> & {};

function SheetTitle({ className, ...props }: SheetTitleProps) {
  return (
    <SheetPrimitive.Title
      data-slot="sheet-title"
      className={cn("font-semibold text-foreground", className)}
      {...props}
    />
  );
}

export default SheetTitle;
