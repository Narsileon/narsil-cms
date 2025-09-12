import { Icon } from "@narsil-cms/components/icon";
import { cn } from "@narsil-cms/lib/utils";

import PaginationLink from "./pagination-link";

type PaginationNextProps = React.ComponentProps<typeof PaginationLink> & {};

function PaginationNext({ className, ...props }: PaginationNextProps) {
  return (
    <PaginationLink
      className={cn("px-2.5 sm:pr-2.5", className)}
      aria-label="Go to next page"
      size="default"
      {...props}
    >
      <span className="hidden sm:block">Next</span>
      <Icon name="chevron-right" />
    </PaginationLink>
  );
}

export default PaginationNext;
