import { type ComponentProps } from "react";

import { useLabels } from "@narsil-cms/components/labels";
import {
  PaginationContent,
  PaginationEllipsis,
  PaginationItem,
  PaginationLink,
  PaginationRoot,
} from "@narsil-cms/components/pagination";

export type LaravelPaginationLinks = {
  first: string;
  last: string;
  next: string | null;
  prev: string | null;
};

export type LaravelPaginationMeta = {
  current_page: number;
  from: number | null;
  last_page: number;
  links: LaravelPaginationMetaLink[];
  path: string;
  per_page: number;
  to: number | null;
  total: number;
};

export type LaravelPaginationMetaLink = {
  active: boolean;
  label: string;
  url: string | null;
};

type PaginationProps = ComponentProps<typeof PaginationRoot> & {
  contentProps?: Partial<ComponentProps<typeof PaginationContent>>;
  links: LaravelPaginationLinks;
  metaLinks?: LaravelPaginationMetaLink[];
};

function Pagination({
  contentProps,
  links,
  metaLinks,
  ...props
}: PaginationProps) {
  const { trans } = useLabels();

  const firstPageLabel = trans("accessibility.first_page", "First page");
  const prevPageLabel = trans("accessibility.previous_page", "Previous page");
  const nextPageLabel = trans("accessibility.next_page", "Next page");
  const lastPageLabel = trans("accessibility.last_page", "Last page");

  return (
    <PaginationRoot {...props}>
      <PaginationContent {...contentProps}>
        <PaginationItem>
          <PaginationLink
            className="rounded-r-none"
            asChild={true}
            disabled={links.prev === null}
            icon="chevron-left"
            linkProps={{
              as: "button",
              href: links.first,
              preserveScroll: true,
              preserveState: true,
            }}
            tooltip={firstPageLabel}
          />
        </PaginationItem>
        <PaginationItem>
          <PaginationLink
            className="rounded-none"
            asChild={true}
            disabled={links.prev === null}
            icon="chevron-left"
            linkProps={{
              as: "button",
              href: links.prev ?? "",
              preserveScroll: true,
              preserveState: true,
            }}
            tooltip={prevPageLabel}
          />
        </PaginationItem>
        {metaLinks?.slice(1, -1).map((link, index) => {
          return link.url ? (
            <PaginationItem key={index}>
              <PaginationLink
                className="rounded-none"
                asChild={true}
                active={link.active}
                linkProps={{
                  as: "button",
                  href: link.url,
                  preserveScroll: true,
                  preserveState: true,
                }}
              >
                {link.label}
              </PaginationLink>
            </PaginationItem>
          ) : (
            <PaginationItem>
              <PaginationLink
                className="rounded-none"
                asChild={true}
                disabled={true}
              >
                <PaginationEllipsis className="border bg-accent" key={index} />
              </PaginationLink>
            </PaginationItem>
          );
        })}
        <PaginationItem>
          <PaginationLink
            className="rounded-none"
            asChild={true}
            disabled={links.next === null}
            icon="chevron-right"
            linkProps={{
              as: "button",
              href: links.next ?? "",
              preserveScroll: true,
              preserveState: true,
            }}
            tooltip={nextPageLabel}
          />
        </PaginationItem>
        <PaginationItem>
          <PaginationLink
            className="rounded-l-none"
            asChild={true}
            disabled={links.next === null}
            icon="chevrons-right"
            linkProps={{
              as: "button",
              href: links.last,
              preserveScroll: true,
              preserveState: true,
            }}
            tooltip={lastPageLabel}
          />
        </PaginationItem>
      </PaginationContent>
    </PaginationRoot>
  );
}

export default Pagination;
