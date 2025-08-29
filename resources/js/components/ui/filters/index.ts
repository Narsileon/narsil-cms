import Filters from "./filters";
import FiltersItem from "./filters-item";

type Filter = {
  column: string;
  operator: string;
  value: string | number;
};

type FilterGroup = {
  operator: "and" | "or";
  filter: Filter;
}[];

export { Filters, FiltersItem };

export type { Filter, FilterGroup };
