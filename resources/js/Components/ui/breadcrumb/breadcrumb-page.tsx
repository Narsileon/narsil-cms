import { cn } from "@/Components";

export type BreadcrumbPageProps = React.ComponentProps<"span"> & {};

function BreadcrumbPage({ className, ...props }: BreadcrumbPageProps) {
  return (
    <span
      className={cn("text-foreground font-normal", className)}
      aria-current="page"
      aria-disabled="true"
      data-slot="breadcrumb-page"
      role="link"
      {...props}
    />
  );
}

export default BreadcrumbPage;
