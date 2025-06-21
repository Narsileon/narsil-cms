import { cn } from "@/lib/utils";

export type TableBopyProps = React.ComponentProps<"tbody"> & {};

function TableBody({ className, ...props }: TableBopyProps) {
  return (
    <tbody
      data-slot="table-body"
      className={cn("[&_tr:last-child]:border-0", className)}
      {...props}
    />
  );
}

export default TableBody;
