import { Link } from "@inertiajs/react";
import useTranslationsStore from "@/stores/translations-store";
import {
  ChevronLeft,
  ChevronRight,
  ChevronsLeft,
  ChevronsRight,
} from "lucide-react";
import {
  Pagination,
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
} from "@/components/ui/pagination";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import type { PaginationProps } from "@/components/ui/pagination";
import type {
  LaravelPaginationLinks,
  LaravelPaginationMeta,
} from "@/types/global";

export type DataTablePaginationProps = PaginationProps & {
  links: LaravelPaginationLinks;
  metaLinks: LaravelPaginationMeta["links"];
};

function DataTablePagination({
  links,
  metaLinks,
  ...props
}: DataTablePaginationProps) {
  const { trans } = useTranslationsStore();

  return (
    <Pagination {...props}>
      <PaginationContent>
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <PaginationItem>
              <PaginationLink asChild={true} isDisabled={links.prev === null}>
                <Link
                  aria-label={trans("accessibility.page_first", "First page")}
                  as="button"
                  href={links.first}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <ChevronsLeft />
                </Link>
              </PaginationLink>
            </PaginationItem>
          </TooltipTrigger>
          <TooltipContent>
            {trans("accessibility.page_first", "First page")}
          </TooltipContent>
        </Tooltip>
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <PaginationItem>
              <PaginationLink asChild={true} isDisabled={links.prev === null}>
                <Link
                  aria-label={trans(
                    "accessibility.page_previous",
                    "Previous page",
                  )}
                  as="button"
                  href={links.prev ?? ""}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <ChevronLeft />
                </Link>
              </PaginationLink>
            </PaginationItem>
          </TooltipTrigger>
          <TooltipContent>
            {trans("accessibility.page_previous", "Previous page")}
          </TooltipContent>
        </Tooltip>
        {metaLinks.slice(1, -1).map((link, index) => {
          return link.url ? (
            <PaginationItem key={index}>
              <PaginationLink asChild={true} isActive={link.active}>
                <Link
                  as="button"
                  href={link.url}
                  preserveScroll={true}
                  preserveState={true}
                >
                  {link.label}
                </Link>
              </PaginationLink>
            </PaginationItem>
          ) : (
            <PaginationEllipsis key={index} />
          );
        })}
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <PaginationItem>
              <PaginationLink asChild={true} isDisabled={links.next === null}>
                <Link
                  aria-label={trans("accessibility.page_next", "Next page")}
                  as="button"
                  href={links.next ?? ""}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <ChevronRight />
                </Link>
              </PaginationLink>
            </PaginationItem>
          </TooltipTrigger>
          <TooltipContent>
            {trans("accessibility.page_next", "Next page")}
          </TooltipContent>
        </Tooltip>
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <PaginationItem>
              <PaginationLink asChild={true} isDisabled={links.next === null}>
                <Link
                  aria-label={trans("accessibility.page_last", "Last page")}
                  as="button"
                  href={links.last}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <ChevronsRight />
                </Link>
              </PaginationLink>
            </PaginationItem>
          </TooltipTrigger>
          <TooltipContent>
            {trans("accessibility.page_last", "Last page")}
          </TooltipContent>
        </Tooltip>
      </PaginationContent>
    </Pagination>
  );
}

export default DataTablePagination;
