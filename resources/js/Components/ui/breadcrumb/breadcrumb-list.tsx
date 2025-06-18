import { cn } from "@/Components";

export type BreadcrumbListProps = React.ComponentProps<"ol"> & {};

function BreadcrumbList({ className, ...props }: BreadcrumbListProps) {
  return (
    <ol
      className={cn(
        "text-muted-foreground flex flex-wrap items-center gap-1.5 text-sm break-words sm:gap-2.5",
        className,
      )}
      data-slot="breadcrumb-list"
      {...props}
    />
  );
}

export default BreadcrumbList;
