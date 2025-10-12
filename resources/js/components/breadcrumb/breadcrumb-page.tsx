import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type BreadcrumbPageProps = ComponentProps<"span">;

function BreadcrumbPage({ className, ...props }: BreadcrumbPageProps) {
  return (
    <span
      data-slot="breadcrumb-page"
      className={cn("text-foreground font-normal", className)}
      aria-current="page"
      aria-disabled="true"
      role="link"
      {...props}
    />
  );
}

export default BreadcrumbPage;
