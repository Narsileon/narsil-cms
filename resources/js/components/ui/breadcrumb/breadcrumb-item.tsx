import { cn } from "@/components";

export type BreadcrumbItemProps = React.ComponentProps<"li"> & {};

function BreadcrumbItem({ className, ...props }: BreadcrumbItemProps) {
  return (
    <li
      data-slot="breadcrumb-item"
      className={cn("inline-flex items-center gap-1.5", className)}
      {...props}
    />
  );
}

export default BreadcrumbItem;
