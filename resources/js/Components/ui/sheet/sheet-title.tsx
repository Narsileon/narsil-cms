import { cn } from "@/Components";
import { Title } from "@radix-ui/react-dialog";

export type SheetTitleProps = React.ComponentProps<typeof Title> & {};

function SheetTitle({ className, ...props }: SheetTitleProps) {
  return (
    <Title
      data-slot="sheet-title"
      className={cn("text-foreground font-semibold", className)}
      {...props}
    />
  );
}

export default SheetTitle;
