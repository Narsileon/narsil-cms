import { cn } from "@/lib/utils";

type TableRowProps = React.ComponentProps<"tr"> & {};

function TableRow({ className, ...props }: TableRowProps) {
  return (
    <tr
      data-slot="table-row"
      className={cn(
        "border-b transition-colors",
        "hover:bg-muted/50",
        className,
      )}
      {...props}
    />
  );
}

export default TableRow;
