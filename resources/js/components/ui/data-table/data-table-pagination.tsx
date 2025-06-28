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
                  aria-label={trans("tooltips.pagination.first")}
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
          <TooltipContent>{trans("tooltips.pagination.first")}</TooltipContent>
        </Tooltip>
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <PaginationItem>
              <PaginationLink asChild={true} isDisabled={links.prev === null}>
                <Link
                  aria-label={trans("tooltips.pagination.previous")}
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
            {trans("tooltips.pagination.previous")}
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
                  aria-label={trans("tooltips.pagination.next")}
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
          <TooltipContent>{trans("tooltips.pagination.next")}</TooltipContent>
        </Tooltip>
        <Tooltip>
          <TooltipTrigger asChild={true}>
            <PaginationItem>
              <PaginationLink asChild={true} isDisabled={links.next === null}>
                <Link
                  aria-label={trans("tooltips.pagination.last")}
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
          <TooltipContent>{trans("tooltips.pagination.last")}</TooltipContent>
        </Tooltip>
      </PaginationContent>
    </Pagination>
  );
}

export default DataTablePagination;
