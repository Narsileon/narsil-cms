import { type ComponentProps } from "react";

type PaginationItemProps = ComponentProps<"li">;

function PaginationItem({ ...props }: PaginationItemProps) {
  return <li data-slot="pagination-item" {...props} />;
}

export default PaginationItem;
