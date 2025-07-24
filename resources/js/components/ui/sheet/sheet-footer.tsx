import { cn } from "@narsil-cms/lib/utils";

type SheetFooterProps = React.ComponentProps<"div"> & {};

function SheetFooter({ className, ...props }: SheetFooterProps) {
  return (
    <div
      data-slot="sheet-footer"
      className={cn("mt-auto flex flex-col gap-2 p-4", className)}
      {...props}
    />
  );
}

export default SheetFooter;
