import { cn } from "@narsil-cms/lib/utils";

type TableFooterProps = React.ComponentProps<"tfoot"> & {};

function TableFooter({ className, ...props }: TableFooterProps) {
  return (
    <tfoot
      data-slot="table-footer"
      className={cn(
        "border-t bg-muted/50 font-medium",
        "[&>tr]:last:border-b-0",
        className,
      )}
      {...props}
    />
  );
}

export default TableFooter;
