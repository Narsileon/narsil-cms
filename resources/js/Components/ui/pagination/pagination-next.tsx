import { ChevronRightIcon } from "lucide-react";
import { cn } from "@/Components/utils";
import PaginationLink, { PaginationLinkProps } from "./pagination-link";

export type PaginationNextProps = PaginationLinkProps & {};

function PaginationNext({ className, ...props }: PaginationNextProps) {
  return (
    <PaginationLink
      aria-label="Go to next page"
      size="default"
      className={cn("gap-1 px-2.5 sm:pr-2.5", className)}
      {...props}
    >
      <span className="hidden sm:block">Next</span>
      <ChevronRightIcon />
    </PaginationLink>
  );
}

export default PaginationNext;
