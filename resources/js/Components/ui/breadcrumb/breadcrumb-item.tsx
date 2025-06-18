import { cn } from "@/Components";

export type BreadcrumbItemProps = React.ComponentProps<"li"> & {};

function BreadcrumbItem({ className, ...props }: BreadcrumbItemProps) {
  return (
    <li
      className={cn("inline-flex items-center gap-1.5", className)}
      data-slot="breadcrumb-item"
      {...props}
    />
  );
}

export default BreadcrumbItem;
