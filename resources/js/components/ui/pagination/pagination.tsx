import * as React from "react";

type PaginationProps = React.ComponentProps<"nav"> & {};

function Pagination({ ...props }: PaginationProps) {
  return (
    <nav
      data-slot="pagination"
      aria-label="pagination"
      role="navigation"
      {...props}
    />
  );
}

export default Pagination;
