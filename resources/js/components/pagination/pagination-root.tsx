import { type ComponentProps } from "react";

function PaginationRoot({ ...props }: ComponentProps<"nav">) {
  return <nav data-slot="pagination-root" aria-label="Pagination" role="navigation" {...props} />;
}

export default PaginationRoot;
