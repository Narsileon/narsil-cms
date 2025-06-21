import { cn } from "@/lib/utils";

export type SheetFooterProps = React.ComponentProps<"div"> & {};

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
