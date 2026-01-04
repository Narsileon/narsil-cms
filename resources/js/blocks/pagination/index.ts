import Pagination from "./pagination";

type LaravelPaginationLinks = {
  first: string;
  last: string;
  next: string | null;
  prev: string | null;
};

type LaravelPaginationMeta = {
  current_page: number;
  from: number | null;
  last_page: number;
  links: LaravelPaginationMetaLink[];
  path: string;
  per_page: number;
  to: number | null;
  total: number;
};

type LaravelPaginationMetaLink = {
  active: boolean;
  label: string;
  url: string | null;
};

export { Pagination };

export type { LaravelPaginationLinks, LaravelPaginationMeta, LaravelPaginationMetaLink };
