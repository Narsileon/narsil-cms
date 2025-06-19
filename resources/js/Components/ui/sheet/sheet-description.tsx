import { cn } from "@/Components";
import { Description } from "@radix-ui/react-dialog";

export type SheetDescriptionProps = React.ComponentProps<
  typeof Description
> & {};

function SheetDescription({ className, ...props }: SheetDescriptionProps) {
  return (
    <Description
      data-slot="sheet-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default SheetDescription;
