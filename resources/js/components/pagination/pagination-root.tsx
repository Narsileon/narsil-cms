import { type ComponentProps } from "react";

function PaginationRoot({ ...props }: ComponentProps<"nav">) {
  return <nav data-slot="pagination-root" role="navigation" aria-label="Pagination" {...props} />;
}

export default PaginationRoot;
