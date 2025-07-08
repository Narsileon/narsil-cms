import { cn } from "@/lib/utils";

type TableCaptionProps = React.ComponentProps<"caption"> & {};

function TableCaption({ className, ...props }: TableCaptionProps) {
  return (
    <caption
      data-slot="table-caption"
      className={cn("text-muted-foreground mt-4 text-sm", className)}
      {...props}
    />
  );
}
export default TableCaption;
