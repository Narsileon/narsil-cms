import { cn } from "@/components";

export type PaginationProps = React.ComponentProps<"nav"> & {};

function Pagination({ className, ...props }: PaginationProps) {
  return (
    <nav
      data-slot="pagination"
      className={cn("mx-auto flex w-full justify-center", className)}
      aria-label="pagination"
      role="navigation"
      {...props}
    />
  );
}

export default Pagination;
