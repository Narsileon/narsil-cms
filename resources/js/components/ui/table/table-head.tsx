import { cn } from "@/components";

export type TableHeadProps = React.ComponentProps<"th"> & {};

function TableHead({ className, ...props }: TableHeadProps) {
  return (
    <th
      data-slot="table-head"
      className={cn(
        "text-foreground h-10 px-2 text-left align-middle font-medium whitespace-nowrap",
        "[&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-[2px]",
        className,
      )}
      {...props}
    />
  );
}

export default TableHead;
