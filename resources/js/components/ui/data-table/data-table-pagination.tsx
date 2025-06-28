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
import type { LaravelPagination } from "@/types/global";
import type { PaginationProps } from "@/components/ui/pagination";

export type DataTablePaginationProps = PaginationProps &
  Pick<
    LaravelPagination,
    | "first_page_url"
    | "last_page_url"
    | "links"
    | "next_page_url"
    | "prev_page_url"
  > & {};

function DataTablePagination({
  first_page_url,
  last_page_url,
  links,
  next_page_url,
  prev_page_url,
  ...props
}: DataTablePaginationProps) {
  const { trans } = useTranslationsStore();

  return (
    <Pagination {...props}>
      <PaginationContent>
        <Tooltip>
          <TooltipTrigger>
            <PaginationItem>
              <PaginationLink
                asChild={true}
                isDisabled={!first_page_url === null}
              >
                <Link
                  aria-label={trans("tooltips.pagination.first")}
                  as="button"
                  href={first_page_url}
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
          <TooltipTrigger>
            <PaginationItem>
              <PaginationLink
                asChild={true}
                isDisabled={prev_page_url === null}
              >
                <Link
                  aria-label={trans("tooltips.pagination.previous")}
                  as="button"
                  href={prev_page_url ?? ""}
                  preserveScroll={true}
                  preserveState={true}
                >
                  <ChevronLeft />
                </Link>
              </PaginationLink>
            </PaginationItem>
            <TooltipContent>
              {trans("tooltips.pagination.previous")}
            </TooltipContent>
          </TooltipTrigger>
        </Tooltip>
        {links.map((link, index) => {
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
          <TooltipTrigger>
            <PaginationItem>
              <PaginationLink
                asChild={true}
                isDisabled={next_page_url === null}
              >
                <Link
                  aria-label={trans("tooltips.pagination.next")}
                  as="button"
                  href={next_page_url ?? ""}
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
          <TooltipTrigger>
            <PaginationItem>
              <PaginationLink
                asChild={true}
                isDisabled={last_page_url === null}
              >
                <Link
                  aria-label={trans("tooltips.pagination.last")}
                  as="button"
                  href={last_page_url}
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
