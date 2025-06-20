import { cn } from "@/components";

export type SheetHeaderProps = React.ComponentProps<"div"> & {};

function SheetHeader({ className, ...props }: SheetHeaderProps) {
  return (
    <div
      data-slot="sheet-header"
      className={cn("flex flex-col gap-1.5 p-4", className)}
      {...props}
    />
  );
}

export default SheetHeader;
