import { Tooltip } from "@narsil-cms/blocks";
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

type PaginationProps = React.ComponentProps<typeof PaginationRoot> & {
  contentProps?: Partial<React.ComponentProps<typeof PaginationContent>>;
  links: LaravelPaginationLinks;
  metaLinks?: LaravelPaginationMeta["links"];
};

function Pagination({
  contentProps,
  links,
  metaLinks,
  ...props
}: PaginationProps) {
  const { trans } = useLabels();

  return (
    <PaginationRoot {...props}>
      <PaginationContent {...contentProps}>
        <Tooltip tooltip={trans("accessibility.first_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-r-none"
              asChild={true}
              disabled={links.prev === null}
              icon="chevron-left"
              linkProps={{
                "aria-label": trans("accessibility.first_page", "First page"),
                as: "button",
                href: links.first,
                preserveScroll: true,
                preserveState: true,
              }}
            />
          </PaginationItem>
        </Tooltip>
        <Tooltip tooltip={trans("accessibility.previous_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-none"
              asChild={true}
              disabled={links.prev === null}
              icon="chevron-left"
              linkProps={{
                "aria-label": trans(
                  "accessibility.previous_page",
                  "Previous page",
                ),
                as: "button",
                href: links.prev ?? "",
                preserveScroll: true,
                preserveState: true,
              }}
            />
          </PaginationItem>
        </Tooltip>
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
        <Tooltip tooltip={trans("accessibility.next_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-none"
              asChild={true}
              disabled={links.next === null}
              icon="chevron-right"
              linkProps={{
                "aria-label": trans("accessibility.next_page", "Next page"),
                as: "button",
                href: links.next ?? "",
                preserveScroll: true,
                preserveState: true,
              }}
            />
          </PaginationItem>
        </Tooltip>
        <Tooltip tooltip={trans("accessibility.last_page")}>
          <PaginationItem>
            <PaginationLink
              className="rounded-l-none"
              asChild={true}
              disabled={links.next === null}
              icon="chevrons-right"
              linkProps={{
                "aria-label": trans("accessibility.last_page", "Last page"),
                as: "button",
                href: links.last,
                preserveScroll: true,
                preserveState: true,
              }}
            />
          </PaginationItem>
        </Tooltip>
      </PaginationContent>
    </PaginationRoot>
  );
}

export default Pagination;
