import { type ComponentProps } from "react";

import { Button } from "@narsil-cms/blocks";
import { cn } from "@narsil-cms/lib/utils";

type PaginationLinkProps = ComponentProps<typeof Button> & {
  active?: boolean;
};

function PaginationLink({
  className,
  active = false,
  disabled = false,
  size = "icon",
  variant = "outline",
  ...props
}: PaginationLinkProps) {
  return (
    <Button
      data-slot="pagination-link"
      data-active={active}
      className={cn(active && "bg-accent dark:bg-accent", className)}
      aria-current={active ? "page" : undefined}
      disabled={disabled}
      size={size}
      variant={variant}
      {...props}
    />
  );
}

export default PaginationLink;
