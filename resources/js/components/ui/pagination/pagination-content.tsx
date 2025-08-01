import { cn } from "@narsil-cms/lib/utils";

type PaginationContentProps = React.ComponentProps<"ul"> & {};

function PaginationContent({ className, ...props }: PaginationContentProps) {
  return (
    <ul
      data-slot="pagination-content"
      className={cn("flex flex-row items-center gap-1", className)}
      {...props}
    />
  );
}

export default PaginationContent;
