import { type ComponentProps } from "react";

function PaginationItem({ ...props }: ComponentProps<"li">) {
  return <li data-slot="pagination-item" {...props} />;
}

export default PaginationItem;
