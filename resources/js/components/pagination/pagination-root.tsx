import { type ComponentProps } from "react";

type PaginationRootProps = ComponentProps<"nav"> & {};

function PaginationRoot({ ...props }: PaginationRootProps) {
  return (
    <nav
      data-slot="pagination-root"
      aria-label="Pagination"
      role="navigation"
      {...props}
    />
  );
}

export default PaginationRoot;
