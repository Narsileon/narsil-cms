import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

function BreadcrumbList({ className, ...props }: ComponentProps<"ol">) {
  return (
    <ol
      data-slot="breadcrumb-list"
      className={cn(
        "flex flex-wrap items-center gap-1.5 wrap-break-word text-muted-foreground sm:gap-2.5",
        className,
      )}
      {...props}
    />
  );
}

export default BreadcrumbList;
